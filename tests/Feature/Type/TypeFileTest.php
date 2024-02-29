<?php

namespace Tests;

use Kedniko\Vivy\O;
use Kedniko\Vivy\V;
use Kedniko\Vivy\ArrayContext;

uses()->group('file');


test('valid-files', function () {
    $v = V::group([
        'file' => V::files()
            ->maxCount(3)
            ->maxTotalSize(50, 'MB')
            ->each(V::file()
                ->mime('application/javascript', O::ifArrayIndex(0))
                ->mime('application/octet-stream', O::ifArrayIndex(1))
                ->extensionIn(['js', 'phar'])
                ->tap(function (ArrayContext $c) {
                    if ($c->getIndex() === 0) {
                        $c->getField()->asFile()->size(631802 + 1, 'B', O::message('Voglio 631802 B')->once());
                    }
                    if ($c->getIndex() === 1) {
                        $c->getField()->asFile()->maxSize(1, 'B', O::once()->continueOnFailure()->appendAfterCurrent()->message('Voglio max 1 B'));
                    }
                })
                ->minSize(100, 'MB', O::options()->message('Voglio 100 MB')->continueOnFailure())),
        'file2' => V::file()->minSize(300, 'MB', O::options()->message('Voglio almeno 300 MB')),
    ]);

    $validated = $v->validate([
        'file' => [
            'name' => [
                0 => '.storage/vue.global.js',
                1 => '.storage/phpunit-4.8.36.phar',
            ],
            'full_path' => [
                0 => '.storage/vue.global.js',
                1 => '.storage/phpunit-4.8.36.phar',
            ],
            'type' => [
                0 => 'application/javascript',
                1 => 'application/octet-stream',
            ],
            'tmp_name' => [
                0 => '.storage/vue.global.js',
                1 => '.storage/phpunit-4.8.36.phar',
            ],
            'error' => [
                0 => 0,
                1 => 0,
            ],
            'size' => [
                0 => 631802,
                1 => 3100908,
            ],
        ],
        'file2' => [
            'name' => 'vue.global.prod.js',
            'full_path' => 'vue.global.prod.js',
            'type' => 'application/javascript',
            'tmp_name' => '.storage/vue.global.prod.js',
            'error' => 0,
            'size' => 127427,
        ],
    ]);

    $expectedErrors = [
        'file' => [
            [
                'minSize' => ['Voglio 100 MB'],
                'size' => ['Voglio 631802 B'],
            ],
            [
                'maxSize' => ['Voglio max 1 B'],
                'minSize' => ['Voglio 100 MB'],
            ],
        ],
        'file2' => [
            'minSize' => ['Voglio almeno 300 MB'],
        ],
    ];

    expect($validated->errors())->toBe($expectedErrors);
});
