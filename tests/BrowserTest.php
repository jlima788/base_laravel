<?php


namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

class BrowserTest extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public $baseUrl = 'http://localhost';

}
