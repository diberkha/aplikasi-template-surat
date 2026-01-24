<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\StringHelper;

class StringHelperTest extends TestCase
{
    /**
     * Test removing academic titles from names
     *
     * @return void
     */
    public function test_remove_academic_titles_with_dr_prefix()
    {
        $name = 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('KINIK DARSONO', $result);
    }

    public function test_remove_academic_titles_with_single_dr()
    {
        $name = 'Dr. Kinik Darsono';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('KINIK DARSONO', $result);
    }

    public function test_remove_academic_titles_with_suffix_only()
    {
        $name = 'Kinik Darsono, M.Pd.Ked.';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('KINIK DARSONO', $result);
    }

    public function test_remove_academic_titles_with_multiple_suffixes()
    {
        $name = 'Kinik Darsono, S.Pd, M.Pd';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('KINIK DARSONO', $result);
    }

    public function test_remove_academic_titles_empty_string()
    {
        $name = '';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('', $result);
    }

    public function test_remove_academic_titles_name_only()
    {
        $name = 'Kinik Darsono';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('KINIK DARSONO', $result);
    }

    public function test_remove_academic_titles_with_prof_prefix()
    {
        $name = 'Prof. Dr. MAYASARI, M.D.';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('MAYASARI', $result);
    }

    public function test_remove_academic_titles_case_insensitive_prefix()
    {
        $name = 'dr. Budi Santoso, S.Kom';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('BUDI SANTOSO', $result);
    }

    public function test_remove_academic_titles_ners()
    {
        $name = 'Ners. Siti Nurhaliza, S.Kep, M.Kes';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('SITI NURHALIZA', $result);
    }

    public function test_remove_academic_titles_bidan()
    {
        $name = 'Bidan Dewi Lestari, Bd.';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('DEWI LESTARI', $result);
    }

    public function test_remove_academic_titles_perawat()
    {
        $name = 'Perawat Hendra Wijaya, S.Kes';
        $result = StringHelper::removeAcademicTitles($name);
        $this->assertEquals('HENDRA WIJAYA', $result);
    }
}
