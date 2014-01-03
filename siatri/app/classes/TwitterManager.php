<?php
class TwitterManager {
	
	/*
		Retreieve the tweets that contain the hasTag
		@params string hasTag without #. 
	*/
		public function searchTweets($hasTag)
		{
			$hasTag = '%23' + $hasTag;

			$siatriTweets = Twitter::searchTweets($hasTag);
			return $siatriTweets;
		}
	}