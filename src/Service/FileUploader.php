<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;



/**
 *TODO page pour externaliser la méthode de chargement de l'image hors du controller (si temps dispo).
 */

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }
    public function upload(UploadedFile $file)
    {
        $nomFichier = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeNom = $this->slugger->slug($nomFichier);
        $fileName = $safeNom.'-'.uniqid().'.'.$file->getExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {

        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}


