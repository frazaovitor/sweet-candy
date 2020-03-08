<?php

interface ImageOptimizeInterface {
	public function setConfiguration($options);
	public function optimizeImage($options);
}