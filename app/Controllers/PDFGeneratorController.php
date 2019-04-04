<?php

namespace TestApp\Controllers;

use TestApp\Models\Answer;
use TestApp\Models\User;
use TestApp\Models\Test;

use Dompdf\Dompdf;
use Twig_Environment;


class PDFGeneratorController extends Controller {

    public function get($request, $response, $args) {
        $cert = Answer::find((int)$args['id']);
        $user = User::find($cert->user_id);
        $test = Test::find($cert->test_id);
        $loader = new \Twig\Loader\FilesystemLoader('../resources/pdf');
        $twig = new Twig_Environment($loader);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($twig->render('certificate_pdf.twig', [
            'test' => $test,
            'user' => $user
        ]));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
        return $response;

    }
}
