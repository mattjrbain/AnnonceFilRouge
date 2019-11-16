<?php

//public function hydrateAnnonce(array $annonces)
//    {
//        $annoncesTab = array();
//        foreach ($annonces as $datum) {
//            if (is_null($datum['visites'])) {
//                $datum['visites'] = 0;
//            }
//            $dateCreation = DateTime::createFromFormat('Y-m-d H:i:s', $datum['date_creation']);
//            if (!$dateCreation) {
//                $dateCreation = null;
//            }
//            $dateLimite = DateTime::createFromFormat('Y-m-d H:i:s', $datum['date_limite']);
//            if (!$dateLimite) {
//                $dateLimite = null;
//            }
//            try {
//               // $userDAO = new MySQLUtilisateurDAO();
//                $user   = $this->userDAO->getById($datum['user_id']);
//                //$rubDAO = new MySQLRubriqueDAO();
//                $rub    = $this->rubDAO->getById($datum['rubrique_id']);
//            } catch (DAOException $e) {
//                throw new DAOException($e->getMessage());
//            }
//            $annoncesTab[] = new Annonce($user, $rub, $datum['en_tete'], $datum['corps'], $dateCreation, $dateLimite, $datum['visites'], $datum['annonce_id']);
//        }
//        return $annoncesTab;
//    }