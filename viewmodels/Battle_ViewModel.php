<?php
    require_once 'viewmodels/ViewModel.php';
    require_once 'data/data.php';
    require_once 'data/User.php';
    require_once 'data/Pet.php';
    require_once 'utils/string.php';
    require_once 'utils/http.php';
	require_once 'utils/battle_logic.php';

    class Battle_ViewModel extends ViewModel
    {
        /**
         * @var MorpheusPetsData data model
         */
        private $data;

		private $battle;
		
        /**
         * @var User user which is logged in
         */
        private $logged_in_user;

        /**
         * @var Player which the user will battle
         */
        private $enemy_user;

        /**
         * Battle_ViewModel constructor.
         */
        public function __construct( $user )
        {
            parent::__construct();
            $this->logged_in_user = $user;
            $this->data           = MorpheusPetsData::getInstance();
			$this->battle = new Battle();
        }

        public function renderBattle()
        {
            $view_data[ 'page_title' ]         = 'Battle!';
            $view_data[ 'logged_in_user' ] = $this->logged_in_user;

            $this->renderTemplate( 'templates/header.php', $view_data );
            $this->renderTemplate( 'templates/battle_view.php', $view_data );
            $this->renderTemplate( 'templates/footer.php', $view_data );
        }

    }