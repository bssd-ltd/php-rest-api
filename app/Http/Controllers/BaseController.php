<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class BaseController extends Controller
{

    protected function jsonToObject(Request $request, string $model)
    {
        return $this::converter()->deserialize($request->getContent(), $model, 'json');
    }

    private static function converter()
    {
        static $serializer;
        if ($serializer == null) {
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
        }
        return $serializer;
    }

}
