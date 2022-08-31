<?php

namespace App\Http\Controllers;

use OpenApi\Attributes\Info;
use OpenApi\Attributes\Contact;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Info(
    version: '1.0.0',
    description: 'Документация для работы с API микросервиса',
    title: 'Microservice API',
    contact: new Contact(email: 'kirill.popkov.work@gmail.com')
)]
abstract class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
