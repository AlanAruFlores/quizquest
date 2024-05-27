<?php 

    class RankingController{
        private $presenter;
        private $mainSettings;

        public function __construct($presenter, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
        }

        public function get(){
            $this->presenter->render("view/viewRanking.mustache", [...$this->mainSettings]);
        }
    }
?>