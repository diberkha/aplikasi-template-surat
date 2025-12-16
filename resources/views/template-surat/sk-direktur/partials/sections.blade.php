<div class="section">
    <table>
        <tr>
            <td class="section-label">Menimbang</td>
            <td class="section-separator">:</td>
            <td class="section-content">
                @php
                    $menimbangLines = preg_split('/\r\n|\r|\n/', trim($data['menimbang'] ?? ''));
                    $menimbangLines = array_filter($menimbangLines, fn($line) => trim($line) !== '');
                @endphp
                <ol type="a">
                    @foreach($menimbangLines as $line)
                        <li>{{ trim($line) }}</li>
                    @endforeach
                </ol>
            </td>
        </tr>
    </table>
</div>

<div class="section">
    <table>
        <tr>
            <td class="section-label">Mengingat</td>
            <td class="section-separator">:</td>
            <td class="section-content">
                @php
                    $rawMengingat = trim($data['mengingat'] ?? '');
                    $mengingatLines = [];
                    $lines = preg_split('/\r\n|\r|\n/', $rawMengingat);
                    $lines = array_filter($lines, fn($line) => trim($line) !== '');
                    $allAreIds = true; $ids = [];
                    foreach($lines as $line) {
                        $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));
                        if(preg_match('/^\d+$/', $cleaned)) { $ids[] = (int)$cleaned; }
                        else { $allAreIds = false; break; }
                    }
                    if($allAreIds && count($ids) > 0) {
                        $regulasis = \App\Models\Regulasi::whereIn('id_regulasi', $ids)
                            ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $ids) . ')')
                            ->get();
                        if($regulasis->count() > 0) {
                            $mengingatLines = $regulasis->pluck('isi_regulasi')->toArray();
                        } else {
                            $mengingatLines = ['Data regulasi tidak ditemukan'];
                        }
                    } else {
                        foreach($lines as $line) {
                            $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));
                            if($cleaned !== '') { $mengingatLines[] = $cleaned; }
                        }
                    }
                @endphp
                <ol type="1">
                    @foreach($mengingatLines as $line)
                        <li>{{ trim($line) }}</li>
                    @endforeach
                </ol>
            </td>
        </tr>
    </table>
</div>
