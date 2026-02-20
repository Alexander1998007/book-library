<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "Документація для API книг",
    title: "My API"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "Використовуйте токен з .env",
    bearerFormat: "JWT",
    scheme: "bearer"
)]
class OpenApi
{
    // Цей клас використовується тільки для анотацій OpenAPI
}
