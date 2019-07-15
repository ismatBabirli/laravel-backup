<?php


namespace MyVendor;


use Illuminate\Support\Facades\File;

class VendorScript
{

    public function run()
    {

        $this->createDir();
    }

    protected function createDir()
    {

        File::makeDirectory(storage_path('backups'));

    }
}
