<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('ruangan', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->string('nama_ruangan');
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id('id_unit');
            $table->string('nama_unit');
            $table->timestamps();
        });

        Schema::create('template_surat', function (Blueprint $table) {
            $table->id('id_template_surat');
            $table->string('nama_template_surat');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('id_ruangan')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_ruangan')
                ->references('id_ruangan')
                ->on('ruangan')
                ->onDelete('cascade');
        });

        Schema::create('surat', function (Blueprint $table) {
            $table->id('id_surat');
            $table->string('nama_surat');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_dibuat');
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('id_template_surat')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('is_draft')->default(true);
            $table->timestamps();

            $table->foreign('id_template_surat')
                ->references('id_template_surat')
                ->on('template_surat')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('regulasi', function (Blueprint $table) {
            $table->id('id_regulasi');
            $table->text('isi_regulasi');
            $table->timestamps();
        });

        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable()->unique();
            $table->string('jabatan')->nullable();
            $table->string('jenis_pegawai')->default('PNS');
            $table->date('masa_kerja');
            $table->integer('sisa_cuti_tahunan')->default(12);
            $table->integer('sisa_cuti_n')->default(12);
            $table->integer('sisa_cuti_n1')->default(0);
            $table->integer('sisa_cuti_n2')->default(0);
            $table->boolean('is_n_postponed')->default(false);
            $table->boolean('is_n1_postponed')->default(false);
            $table->timestamps();
        });

        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan')->unique();
            $table->timestamps();
        });

        Schema::table('surat', function (Blueprint $table) {
            $table->unsignedBigInteger('id_regulasi')->nullable()->after('id_template_surat');
            $table->foreign('id_regulasi')
                ->references('id_regulasi')
                ->on('regulasi')
                ->onDelete('set null');
        });

        Schema::create('sk_direktur', function (Blueprint $table) {
            $table->id('id_sk_direktur');
            $table->string('judul_surat');
            $table->string('nomor_surat');
            $table->string('tentang');
            $table->text('menimbang');
            $table->text('mengingat');
            $table->text('memutuskan');
            $table->text('menetapkan')->nullable();
            $table->string('tempat_dibuat');
            $table->date('tanggal_dibuat');
            $table->unsignedBigInteger('id_surat')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')
                ->references('id_surat')
                ->on('surat')
                ->onDelete('cascade');
        });

        Schema::create('sop', function (Blueprint $table) {
            $table->id('id_sop');
            $table->unsignedBigInteger('id_surat')->nullable();
            $table->string('judul_sop');
            $table->string('nomor_dokumen');
            $table->string('nomor_revisi')->nullable();
            $table->string('halaman')->nullable();
            $table->date('tanggal_terbit');
            $table->text('pengertian');
            $table->text('tujuan');
            $table->text('kebijakan');
            $table->text('prosedur');
            $table->text('unit_terkait');
            $table->timestamps();

            $table->foreign('id_surat')->references('id_surat')->on('surat')->onDelete('cascade');
        });

        Schema::create('surat_izin_cuti', function (Blueprint $table) {
            $table->id('id_cuti');
            $table->unsignedBigInteger('id_surat')->nullable();
            $table->string('kategori')->default('PNS');
            $table->json('form_data')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')->references('id_surat')->on('surat')->onDelete('cascade');
        });

        Schema::create('cuti_bersama', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_cuti_bersama');
            $table->year('tahun');
            $table->integer('jumlah_hari');
            $table->boolean('is_perhitungan_cuti_tahunan')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kasi', 'Kepala Seksi')");
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kabid', 'Kepala Bidang')");
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kasubag', 'Kepala Sub Bagian')");
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kabag', 'Kepala Bagian')");
    }

public function down(): void
    {
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kepala Seksi', 'Kasi')");
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kepala Bidang', 'Kabid')");
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kepala Sub Bagian', 'Kasubag')");
        DB::statement("UPDATE pegawais SET jabatan = REPLACE(jabatan, 'Kepala Bagian', 'Kabag')");

        Schema::dropIfExists('cuti_bersama');
        Schema::dropIfExists('surat_izin_cuti');
        Schema::dropIfExists('sop');
        Schema::dropIfExists('sk_direktur');
        Schema::dropIfExists('surat');
        Schema::dropIfExists('regulasi');
        Schema::dropIfExists('users');
        Schema::dropIfExists('template_surat');
        Schema::dropIfExists('ruangan');
        Schema::dropIfExists('units');
        Schema::dropIfExists('pegawais');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('jabatans');
    }
};
