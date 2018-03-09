<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : VideoStream.php
	 *   @Created_at : 07/10/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Video;
	use ShirOSBundle\Utils\HTTP\HTTP;
	
	class VideoStream
	{
		/**
		 * Chemin du fichier
		 * @var string | Default Value = ''
		 */
		private $path = '';

		/**
		 * Taille du fichier
		 * @var int | Default Value = -1
		 */
		private $size = -1;

		/**
		 * Longeur du fichier
		 * @var int | Default Value = -1
		 */
		private $length = -1;

		/**
		 * Bit de début de fichier
		 * @var int | Default Value = -1
		 */
		private $start = -1;

		/**
		 * Bit de fin de fichier
		 * @var int | Default Value = -1
		 */
		private $end = -1;

		/**
		 * Flux Video
		 * @var resource
		 */
		private $stream = NULL;

		/**
		 * Buffer de chargement
		 * @var int | Value = 102400
		 */
		private $buffer = 1024 * 8; // 102400
		
		
		/**
		 * VideoStream constructor.
		 *
		 * @param String $filePath
		 */
		public function __construct(String $filePath)
		{
			$this->path = $filePath;

			$this->size = filesize($this->path);
			$this->length = $this->size;

			$this->start = 0;
			$this->end = $this->size - 1;
		}


		/* ------------------------ Load Function ------------------------ */

			/**
			 * Launch the movie
			 */
			public function start()
			{
				$this->open();
				$this->setHeader();
				$this->stream();
				$this->end();
			}
		 

		/* ------------------------ Private Function ------------------------ */
			
			/**
			 * Open Stream
			 */		
			private function open()
			{
				if (!($this->stream = fopen($this->path, 'rb')))
					die('Could not open stream for reading');
			}
			 
			/**
			 * Set Header for the movie content
			 */
			private function setHeader()
			{
				ob_get_clean();

				$code = HTTP::OK;
				$headers = array(
					'Content-Type: video/mp4',
					'Accept-Ranges: bytes',
				);
				 
				if (isset($_SERVER['HTTP_RANGE'])) {
					list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);

					if (strpos($range, ',') !== false) {
						$code = HTTP::REQUESTED_RANGE_UNSATISFIABLE;
						array_push($headers, "Content-Range: bytes $this->start-$this->end/$this->size");
						
						HTTP::generateHeader($code, $headers);
						exit;
					}

					if ($range == '-') {
						$this->start = $this->size - substr($range, 1);
					} else {
						$range = explode('-', $range);
						
						$this->start = $range[0];
						$this->end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $this->end;
					}
					
					$this->end = ($this->end > $this->end) ? $this->end : $this->end;

					if ($this->start > $this->end || $this->start > $this->size - 1 || $this->end >= $this->size) {
						$code = HTTP::REQUESTED_RANGE_UNSATISFIABLE;
						array_push($headers, "Content-Range: bytes $this->start-$this->end/$this->size");
						
						HTTP::generateHeader($code, $headers);
						exit;
					}

					$this->length = $this->end - $this->start + 1;

					fseek($this->stream, $this->start);
					$code = HTTP::PARTIAL_CONTENT;
				}
				
				array_push($headers, 'Content-Length: ' . $this->length);
				array_push($headers, "Content-Range: bytes $this->start-$this->end/$this->size");
				
				HTTP::generateHeader($code, $headers);
			}
			
			/**
			 * Close Stream
			 */			
			private function end()
			{
				fclose($this->stream);
				exit();
			}
			 
			/**
			 * Perform Stream
			 */			
			private function stream()
			{
				while(!feof($this->stream) && ($p = ftell($this->stream)) <= $this->end) {
					if ($p + $this->buffer > $this->end) {
						$this->buffer = $this->end - $p + 1;
					}

					set_time_limit(0);
					echo fread($this->stream, $this->buffer);
					flush();
				}
			}
	}
?>