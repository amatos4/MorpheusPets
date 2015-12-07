<?php
    require_once 'viewmodels/ViewModel.php';
    require_once 'data/data.php';
    require_once 'data/User.php';
    require_once 'data/Pet.php';
    require_once 'utils/string.php';
    require_once 'utils/http.php';

    class Profile_ViewModel extends ViewModel
    {
        /**
         * @var MorpheusPetsData data model
         */
        private $data;

        /**
         * @var User user which is logged in
         */
        private $logged_in_user;

        /**
         * @var User user which the profile belongs to
         */
        private $profile_user;

        /**
         * @var array all of the user's pet collection
         */
        private $pet_collection = [ ];

        /**
         * @var array all of the user's non-active pet collection
         */
        private $nonactive_pet_list = [ ];

        /**
         * @var array all of the user's active pets
         */
        private $active_pet_list = [ ];

        /**
         * Profile_ViewModel constructor.
         */
        public function __construct( $user , $profileUser )
        {
            parent::__construct();
            $this->logged_in_user = $user;
            $this->profile_user = $profileUser;
            $this->data           = MorpheusPetsData::getInstance();
        }


        public function setPetCollection ( $collection )
        {
            $this->pet_collection = $collection;
        }

        /**
         * @param Pet $pet from collection
         */
        public function addPetToNonActive ( $pet )
        {
            if ( isset( $pet ) )
            {
                array_push( $this->nonactive_pet_list, $pet );
            }
        }

        /**
         * @param Pet $pet from collection
         */
        public function addPetToActive ( $pet )
        {
            if ( isset( $pet ) )
            {
                array_push( $this->active_pet_list, $pet );
            }
        }

        public function renderProfile()
        {
            $view_data[ 'page_title' ]         = 'User Profile';
            $view_data[ 'js' ]                 = '<script src="js/user_profile.js"></script>';

            $view_data[ 'pet_collection' ] = $this->pet_collection;
            $view_data[ 'active_pets' ] = $this->active_pet_list;
            $view_data[ 'nonactive_pets' ] = $this->nonactive_pet_list;
            $view_data[ 'profile_user' ] = $this->profile_user;
            $view_data[ 'logged_in_user' ] = $this->logged_in_user;

            if($this->logged_in_user == $this->profile_user)
            {
                $view_data[ 'can_edit_profile' ] = true;
            }

            $this->renderTemplate( 'templates/header.php', $view_data );
            $this->renderTemplate( 'templates/profile_view.php', $view_data );
            $this->renderTemplate( 'templates/footer.php', $view_data );
        }

        /** @param array $ret */
        public function renderSearchResults( $ret , $query )
        {
            $view_data[ 'page_title' ]         = 'User Profile';
            $view_data[ 'js' ]                 = '<script src="js/user_profile.js"></script>';

            $view_data[ 'search_results' ] = $ret;
            $view_data[ 'search_query'] = $query;

            $this->renderTemplate( 'templates/header.php', $view_data );
            $this->renderTemplate( 'templates/search_results.php', $view_data );
            $this->renderTemplate( 'templates/footer.php', $view_data );
        }

    }