<?php

namespace Company\Model;


use Company\Entity\ImageInterface;

interface ImageModelInterface
{
    /**
     * Retrieve all images for given Company ID
     *
     * @param int $companyId
     * @return ImageInterface[]
     */
    public function fetchAllImages($companyId);

    /**
     * Find an image by given Image ID
     *
     * @param int $companyId
     * @param int $imageId
     * @return ImageInterface
     */
    public function findImageById($companyId, $imageId);

    /**
     * Store an Image in the backend
     *
     * @param ImageInterface $image
     * @return ImageInterface
     */
    public function saveImage(ImageInterface $image);

    /**
     * Remove an Image from the backend
     *
     * @param ImageInterface $image
     * @return bool
     */
    public function deleteImage(ImageInterface $image);
}