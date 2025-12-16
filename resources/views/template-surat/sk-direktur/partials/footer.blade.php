<div class="footer">
    <table>
        <tr>
            <td class="footer-left"></td>
            <td class="footer-right">
                <p>Ditetapkan di {{ $data['lokasi_surat'] ?? 'Gemolong' }}</p>
                <p>Pada tanggal {{ \Carbon\Carbon::parse($data['tanggal_dibuat'] ?? now())->locale('id')->translatedFormat('j F Y') }}</p>
                <p class="footer-title" style="margin-top: 10px;">DIREKTUR RSUD dr. SOERATNO GEMOLONG</p>
                <p class="footer-title">KABUPATEN SRAGEN</p>
                <div class="signature-wrapper">
                    @if(!empty($data['ttd_image']))
                        <img src="{{ public_path($data['ttd_image']) }}" alt="Tanda tangan">
                    @else
                        <div style="height: 90px"></div>
                    @endif
                </div>
                <p class="signature-name">{{ $data['pejabat_nama'] ?? 'KINIK DARSONO' }}</p>
                @if(!empty($data['pejabat_nip']))
                    <p class="signature-nip">NIP. {{ $data['pejabat_nip'] }}</p>
                @endif
            </td>
        </tr>
    </table>
</div>
