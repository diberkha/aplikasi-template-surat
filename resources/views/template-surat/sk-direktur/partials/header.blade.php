<div class="header">
    <table>
        <tr>
            <td class="header-logo">
                @php
                    $logoLeftPath = public_path('img/logo-sragen-kop.jpeg');
                    $logoLeftData = '';
                    if (file_exists($logoLeftPath)) {
                        $logoLeftData = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoLeftPath));
                    }
                @endphp
                @if($logoLeftData)
                    <img src="{{ $logoLeftData }}" alt="Logo Sragen">
                @endif
            </td>
            <td class="header-text">
                <div class="header-line1">PEMERINTAH KABUPATEN SRAGEN</div>
                <div class="header-line2">RSUD dr. SOERATNO GEMOLONG</div>
                <div class="header-line3">
                    Jalan R. Ngt. Tjitrosantjoko 10, Gemolong, Sragen, Jawa Tengah 57274<br>
                    Telepon (0271) 6811839, Laman rsudgemolong.sragenkab.go.id, Pos-el rsudgemolong@gmail.com
                </div>
            </td>
            <td class="header-logo-right">
                @php
                    $logoRightPath = public_path('img/logo-rs-kop.png');
                    $logoRightData = '';
                    if (file_exists($logoRightPath)) {
                        $logoRightData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoRightPath));
                    }
                @endphp
                @if($logoRightData)
                    <img src="{{ $logoRightData }}" alt="Logo RS">
                @endif
            </td>
        </tr>
    </table>
    <div class="header-border">
        <div class="header-border-inner"></div>
    </div>
</div>
