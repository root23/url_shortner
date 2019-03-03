<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="PROJECT TITLE",
 *         @SWG\Contact(
 *             email="your@email.com"
 *         ),
 *     )
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="query",
 *   name="api_key"
 * )
 */

class ApiController extends Controller
{
    //
}