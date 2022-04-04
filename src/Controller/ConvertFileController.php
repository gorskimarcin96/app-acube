<?php

namespace App\Controller;

use App\Entity\ConvertFile;
use App\Repository\ConvertFileRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\InvalidArgumentException;

#[Route('/convert/file', name: 'convert_file_')]
class ConvertFileController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route('/create/{from}/{to}', name: 'create', methods: 'post')]
    public function create(
        Request $request,
        ConvertFileRepository $convertFileRepository,
        string $from,
        string $to
    ): Response {
        if (!$request->files->has('file')) {
            return new JsonResponse(['error' => 'File not uploaded.'], 400);
        }

        try {
            $file = $convertFileRepository->create($request->files->get('file')->getContent(), $from, $to);

            return JsonResponse::fromJsonString($this->serializer->serialize($file, 'json'), Response::HTTP_CREATED);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 400);
        } catch (Exception $exception) {
            return new JsonResponse(['error' => 'Bad request.'], 400);
        }
    }

    #[Route('/get/{convertFile}', name: 'get', methods: 'get')]
    public function find(ConvertFile $convertFile): Response
    {
        return JsonResponse::fromJsonString($this->serializer->serialize($convertFile, 'json'), Response::HTTP_OK);
    }
}
