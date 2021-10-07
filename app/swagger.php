<?php
/**
 * @OA\Info(
 *         version="1.0.0",
 *         title="Digible API",
 *         description="<h1>Description</h1>",
 * ),
 *
 * @OA\Server(url=API_PATH),
 *
 * @OA\PathItem(
 *     path="/"
 * ),
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * ),
 */
