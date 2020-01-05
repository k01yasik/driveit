<?php

use Illuminate\Database\Seeder;

class ResponsiveImages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dir = 'F:/default';

        $files = array_diff(scandir($dir), array('..', '.'));

        foreach ($files as $file) {
            $full_path = $dir.'/'.$file;
            $short_path = substr($full_path, 0, -5);
            exec('convert '.$full_path.' -resize 300x200 '.$short_path.'-300w.webp');
        }
    }
}
