<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ruangan', function (Blueprint $table) {
        $table->id('id_ruangan');
            $table->string('nama_ruangan');
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
            $table->unsignedBigInteger('id_template_surat')->nullable();
            $table->json('isi_regulasi');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('id_template_surat')
                ->references('id_template_surat')
                ->on('template_surat')
                ->onDelete('set null');

            $table->foreign('id_surat')
                ->references('id_surat')
                ->on('surat')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('sk_direktur', function (Blueprint $table) {
            $table->id('id_sk_direktur');
            $table->string('judul_surat');
            $table->string('nomor_surat');
            $table->string('tentang');
            $table->string('identitas_penetap');
            $table->string('menimbang');
            $table->string('mengingat');
            $table->string('memutuskan');
            $table->string('menetapkan');
            $table->string('tempat_dibuat');
            $table->date('tanggal_dibuat');
            $table->unsignedBigInteger('id_surat')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')
                ->references('id_surat')
                ->on('surat')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sk_direktur');
        Schema::dropIfExists('regulasi');
        Schema::dropIfExists('surat');
        Schema::dropIfExists('users');
        Schema::dropIfExists('template_surat');
        Schema::dropIfExists('ruangan');
    }
};
