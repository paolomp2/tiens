<?php
return [
    /*
     * The relative path of the folder where the package stores the files
     */
    'relative_path'        => 'zotyo/ajax-file-uploader/uploads',
    /*
     *
     */
    'route'                => [
        // If you want to define your route instead of the package
        'disable' => false,
        //  Details for the preconfigured upload route
        'url'     => 'upload',
        'alias'   => 'upload',
    ],
    /*
     * Validation rule for the file
     */
    'file-validation-rule' => 'required|min:0',
    /*
     * Name of the file input the package is waiting for
     */
    'file-name'            => 'file',
];
