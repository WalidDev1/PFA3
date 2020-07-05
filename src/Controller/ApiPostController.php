<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Aime;
use App\Entity\Client;
use App\Entity\Images;
use App\Entity\Offre;
use App\Entity\Quartier;
use App\Entity\User;
use App\Entity\Vendeur;
use App\Entity\VendeurRegulier;
use App\Entity\Ville;
use App\Repository\AgenceRepository;
use App\Repository\AimeRepository;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use App\Repository\ConditionRepository;
use App\Repository\ImagesRepository;
use App\Repository\OffreRepository;
use App\Repository\TypeContratRepository;
use App\Repository\UserRepository;
use App\Repository\VendeurRegulierRepository;
use App\Repository\VendeurRepository;
use App\Repository\VilleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Offre as EntityOffre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\VarDumper;
use App\Services\Api\Serializer\ObjectSerializer;


class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index" , methods={"GET"})
     */
    public function index(UserRepository $userRepo , SerializerInterface $serialiser)
    {
        $response = $this->json($userRepo->findAll() , 200 ,[],['groups' => 'post:read']);
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/Ajouter", name="api_Ajouter" , methods={"POST"})
     */
    public function AjouterAnnonce(  Request $request,OffreRepository $OffreRepo ,VilleRepository $VilleRepo,TypeContratRepository $ContatRepo,CategoryRepository $CategoryRepo ,VendeurRepository $Vendeurepo ,EntityManagerInterface $em)
    {
        $Offre = new Offre();
        if($request->request->get("id") != null &&
        $request->request->get("titre") != null &&
        $request->request->get("prix") != null &&
        $request->request->get("etage") != null &&
        $request->request->get("bain") != null &&
        $request->request->get("surface") != null &&
        $request->request->get("verdure") != null &&
        $request->request->get("construction") != null &&
        $request->request->get("parking") != null &&
        $request->request->get("quartierNom") != null &&
        $request->request->get("quartierlat") != null &&
        $request->request->get("quartierlog") != null &&
        $request->request->get("villelog") != null &&
        $request->request->get("villelat") != null &&
        $request->request->get("piece") != null &&
        $request->request->get("typeImmo") != null &&
        $request->request->get("typeContract") != null &&
        $request->request->get("villeNom") != null 
        ){
            $dateReq = new DateTime();
            $quartier = new Quartier();
            $ville = new Ville();
            $find = false ;
            $ville->setNom($request->request->get("villeNom"));
            $ville->setLat($request->request->get("villelat"));
            $ville->setLog($request->request->get("villelog"));
            // on cherche si cette ville existe deja dans notre base donne en se basant sur ton nom 
            $listeVille = $VilleRepo->findAll();
            foreach ($listeVille  as $item){
                if((strpos($item->getNom(), $ville->getNom())) !== false){
                    $ville =  $item; 
                    $find = true;
                break;
                }

            }
            // dans le cas ou cette ville n'existe pas 
            if($find == false){
                $em->persist($ville);
                $em->flush();
            }
            $quartier->setVille($ville);
            $quartier->setNomQ($request->request->get("quartierNom") );
            $quartier->setLat($request->request->get("quartierlat") );
            $quartier->setLog($request->request->get("quartierlog") );
            $em->persist($quartier);
            $em->flush();
            $Offre->setVendeur($Vendeurepo->findOneBy([
                'id'=>$request->request->get("id")
            ])); 
            $Offre->setDescription($request->request->get("Description"));
            $Offre->setStatue("En cour de verification");
            $Offre->setTitre($request->request->get("titre")); 
            $Offre->setPrix($request->request->get("prix"));
            $Offre->setNombreEtage($request->request->get("etage"));
            $Offre->setNombreSalleBain($request->request->get("bain"));
            $Offre->setSurface($request->request->get("surface"));
            $Offre->setVerdure($request->request->get("verdure"));
            $Offre->setCreateAt(new \Datetime());
            $Offre->setConstruiteAt(new \Datetime());//($dateReq->format($request->request->get("construction")
            $Offre->setNombreParking($request->request->get("parking"));
            $Offre->setQuartier($quartier);
            $Offre->setPiece($request->request->get("piece"));
            $Offre->setTypeImmobilier($CategoryRepo->findOneBy([
                'id' => $request->request->get("typeImmo")
            ]));  
            $Offre->setTypeContrat($ContatRepo->findOneBy([
                'id' =>$request->request->get("typeContract") 
            ]));
            $em->persist($Offre); 
            $em->flush();
            if($request->files->get('image') != null){
               foreach($request->files->get('image') as $item){
                $imagedb = new Images();
                $file = md5(uniqid()).'.'.$item->getClientOriginalExtension();
                $item->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $imagedb->setUrl('/imagesUploadedT/'.$file);
                $imagedb->setOffre($Offre);
                $em->persist($imagedb);
                $em->flush();
               }
            }
            $response = $this->json([
                'statut' => 201,
                'message' => 'Offre Cree'
            ] , 201);
        }else{
            $response = $this->json([
                'statut'=> 400,
                'message'=> 'ellement manquant !'
            ] , 400 );
        }
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }



    /**
     * @Route("/api/checkUser", name="api_Usercheck_index" , methods={"POST"})
     */
    public function checkUser(UserRepository $UserRepo,ClientRepository $clientRepo ,AimeRepository $AimeRepo ,VendeurRepository $VendeurRepo , VendeurRegulierRepository $VendeurRegRepo , AgenceRepository $AgenceRepo, Request $request )
    {
        $Profile = 1; // 1 : Client , 2 : vendeur , 3 : vendeur Regulier , 4 : Agence
        $user = new User();
        $idC = null;
        $Vendeur = new Vendeur();
        $annonces = [] ;
        $client = new Client();
        // typeP { 1 : client }
        $rep = $UserRepo->findAll();
        foreach ($rep  as $item){

            if ( ($item->getEmail() == $request->request->get("mail")) &&  (password_verify($request->request->get("pass"), $item->getPassword()))) {
               $likes = [] ;
                if($item->getTypeP() == 2) {
                    $Vendeur = $VendeurRepo->findOneBy([
                        "user" => $item,
                       ]);
                    $VendeurRegulier = $VendeurRepo->findOneBy([
                        "user" => $item,
                        ]);
                    $Agence = $VendeurRepo->findOneBy([
                        "user" => $item,
                        ]);
                        
                    if ($Vendeur != null){
                        $Profile = 2;
                    }else if ($VendeurRegulier != null){
                        $Profile = 3;
                    }else if ($Agence != null){
                        $Profile = 4;
                    }
                     foreach ($Vendeur->getOffre() as $key => $val) {
                       array_push($annonces ,$val->getId());
                    }
                }else{
                    $idC = $clientRepo->findOneBy(['user'=>$item]);
                    $listelike = $AimeRepo->getLikes($idC);
                    foreach ($listelike as $key => $like) {
                       array_push($likes,['id_Offre'=>$like->getOffre()[0]->getId()]);
                    }
                    
                }
                $response = $this->json([
                    'status'=> 200,
                    'message'=> "Utilisateur Existant",
                    'Profile'=> $Profile,
                    'userInfo' => $item,
                    'client'=>($idC != null)? $idC : null,
                    'vendeur_id'=> ($Vendeur != null)? ['id'=>$Vendeur->getId(),'annonces_id'=>$annonces] : null,
                    'like'=>$likes
                ], 200 );
                break;
            } else {
                $response = $this->json([
                    'status'=> 401,
                    'message'=> "Utilisateur inexistant !"
            ], 401 );
            }
        }
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/ConditionUse", name="ConditionUse" , methods={"GET"})
     */
    public function Condition(ConditionRepository $ConditionRepo)
    {
        $result = $ConditionRepo->findAll();
        $response = $this->json($result[0] , 200 ,[]);
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/UpdateOffre", name="UpdateOffre" , methods={"POST"})
     */
    public function UpdateOffre(OffreRepository $OffreRepo , Request $request , EntityManagerInterface $em)
    {
        $Offre = $OffreRepo->findOneBy(['id'=>$request->request->get('id')]);
        ($request->request->get('titre')) ? $Offre->getTitre($request->request->get('titre')) : false ;
        ($request->request->get('date'))? $Offre->getTitre($request->request->get('date')) : false ;
        ($request->request->get('quatier'))? $Offre->getTitre($request->request->get('quatier')) : false ;
        ($request->request->get('ville'))? $Offre->getTitre($request->request->get('ville')) : false ;
        ($request->request->get('images'))? $Offre->getTitre($request->request->get('images')) : false ;
        ($request->request->get('prix'))? $Offre->getTitre($request->request->get('prix')) : false ;
        ($request->request->get('surface'))? $Offre->getTitre($request->request->get('surface')) : false ;
        $response = $this->json([
            'statut' => 200 ,
            'message' => 'done'
        ] , 200);
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }
    
    /**
     * @Route("/api/Update", name="Update" , methods={"POST"})
     */
    public function UpdateProfile(Request $request,UserRepository $UserRepo,ImagesRepository $imageRepo,EntityManagerInterface $em)
    {
        $reponse = [];
        $user = $UserRepo->findOneBy([
            'id'=>$request->request->get('id'),
        ]);
        if($user != null){
            
            if($request->files->get('image') != null){
                $imagedb = new Images();
                $images = $request->files->get('image');
                $file = md5(uniqid()).'.'.$images->getClientOriginalExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $imagedb->setUrl('/imagesUploadedT/'.$file);
                $em->persist($imagedb);
                $em->flush();
                $imagecreated = $imageRepo->findOneBy([
                    "url" => $imagedb->getUrl()
                ]);
                $user->setImage($imagecreated);
            }
            ($request->request->get('nom'))? $user->setNom($request->request->get('nom')) : false;
            ($request->request->get('prenom'))? $user->setPrenom($request->request->get('prenom')) : false;
            ($request->request->get('tele'))? $user->setNom($request->request->get('tele')) : false;
            $em->persist($user);
            $em->flush();
            $reponse = $this->json([
                'statut' => 200,
                'message' => 'User modifier',
            ],200);
        }else{
            $reponse = $this->json([
                'statut' => 404,
                'message' => 'User modifier',
            ],404);
        }
        return $reponse;
    }

    /**
     * @Route("/api/dislike", name="dislike" , methods={"POST"})
     */
    public function dislike(OffreRepository $OffreRepo,Request $request,ClientRepository $ClientRepo,AimeRepository $AimeRepo,EntityManagerInterface $em)
    {
        $reponse = "Done";
        $statut = 201;

        $Offre = $OffreRepo->findOneBy([
            'id' => $request->request->get('id_offre')
        ]);
        $Client = $ClientRepo->findOneBy([
            'id' => $request->request->get('id_client')
        ]); 
        $Aime = $AimeRepo->findOneBy([
            'offre' => $Offre->getId(),
            'client' => $Client->getId()
        ]); 
        dd($Aime);
        if ($Offre == null) {
            $reponse = "Offre introuvable";
            $statut = 404;
        } elseif ($Client == null) {
            $reponse = "client introuvable";
            $statut = 404;
        }else{
        $em->remove($Aime);
        $em->flush();
        }

        $response = $this->json([
            'statut'=>$statut,
            'message'=>$reponse
        ], $statut );
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/like", name="Like" , methods={"POST"})
     */
    public function like(OffreRepository $OffreRepo,Request $request,ClientRepository $ClientRepo,EntityManagerInterface $em)
    {
        $reponse = "Done";
        $statut = 201;
        $Offre = $OffreRepo->findOneBy([
            'id' => $request->request->get('id_offre')
        ]);
        $Client = $ClientRepo->findOneBy([
            'id' => $request->request->get('id_client')
        ]);
        if ($Offre == null) {
            $reponse = "Offre introuvable";
            $statut = 404;
            
        } elseif ($Client == null) {
            $reponse = "client introuvable";
            $statut = 404;
        }else{
            $aime = new Aime();
            $aime->addOffre($Offre);
            $aime->addClient($Client);
            $em->persist($aime);
            $em->flush();
        }
        $response = $this->json([
            'statut'=>$statut,
            'message'=>$reponse
        ], $statut );
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/Offre/{id}", name="Offre" , methods={"GET"})
     */
    public function Offre(OffreRepository $OffreRepo , $id)
    {
        $result = $OffreRepo->findOneBy([
            'id'=>$id
        ]);
        $images = [] ;
        for ($i=0; $i < $result->getImages()->count(); $i++) { 
            array_push($images ,$result->getImages()[$i]->getUrl());
        }
        $response = $this->json([
            'statut'=> 200,
           
            'Vendeur'=>[
                'id'=>$result->getVendeur()->getId(),
                'nom'=>$result->getVendeur()->getUser()->getNom(),
                'prenom'=>$result->getVendeur()->getUser()->getPrenom(),
                'Rank'=>4,
                'nombreLike'=>100,
                'telephone'=>$result->getVendeur()->getUser()->getTelephone(),
                'nombre_Propriete'=>$result->getVendeur()->getOffre()->count(),
                'mail'=>$result->getVendeur()->getUser()->getEmail(),
                'image'=>($result->getVendeur()->getUser()->getImage() != null) ? $result->getVendeur()->getUser()->getImage()->getUrl():null,
                'annonces'=>$result->getVendeur()->getOffre()->count()
            ],
            'offre'=>[
                'titre'=>$result->getTitre(),
                'adresse'=>[
                    'quartier'=>[
                        'nom'=>$result->getQuartier()->getNomQ(),
                        'lat'=>$result->getQuartier()->getLat(),
                        'lng'=>$result->getQuartier()->getLog(),
                    ],
                    'ville'=>[
                        'nom'=>$result->getQuartier()->getVille()->getNom(),
                        'lat'=>$result->getQuartier()->getVille()->getLat(),
                        'lng'=>$result->getQuartier()->getVille()->getLog(),
                    ]
                ],
                'prix'=>$result->getPrix(),
                'description'=>$result->getDescription(),
                'images'=> $images,
                'Piece'=>$result->getPiece(),
                'Parking'=>$result->getNombreParking(),
                'Surface'=>$result->getSurface(),
                'Bain'=>$result->getNombreSalleBain(),
                'DatePublic'=>$result->getCreateAt(),
                'DateConst'=>$result->getConstruiteAt(),
                'Verdure'=>$result->getVerdure(),
                
            ]
        ], 200 );
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

     /**
     * @Route("/api/SetProno", name="Prono" , methods={"POST"})
     */
    public function Promo(Request $request ,VendeurRepository $VendeurRepo ,EntityManagerInterface $em)
    {
        // prono = 1 Pack Vendeur Regulier , 2 pack agence
        if ($request->request->get("Promo") == 1){
        $vendeur = $VendeurRepo->findOneBy(["id" => $request->request->get("id")]);
        $vendeurReg = new VendeurRegulier();
        $vendeurReg->setVendeur($vendeur);
        $vendeurReg->setDateMutAt(new \Datetime());
        $em->persist($vendeurReg);
        $em->flush();
        $response = $this->json([
            'status'=> 201,
            'message'=> 'Vendeur Ajouter'
        ] , 201 );
        }else{
        $vendeur = $VendeurRepo->findOneBy(["id" => $request->request->get("id")]);
        $Agenge = new Agence();
        $Agenge->setVendeur($vendeur);
        $Agenge->setDateMutAt(new \Datetime());
        $em->persist($Agenge);
        $em->flush();
        $response = $this->json([
            'status'=> 201,
            'message'=> 'Agence Ajouter'
        ] , 201 );
        }
       
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/Vendeur/{id}/{Pa}", name="api_Vendeur_info" , methods={"GET"})
     */
    public function getProfile($id = null , $Pa = null ,VendeurRepository $vendeurRepo , VendeurRegulierRepository $vendeurRrepo , AgenceRepository $agenceRepo)
    {
        $vendeur = null;
        $res = null;
        $annonces = [];
        switch ($Pa) {
            case '1':
                $vendeur = $vendeurRrepo->findOneBy([
                    'id'=>$id,
                ]);  
                break;
            case '2':
                $vendeur = $agenceRepo->findOneBy([
                    'id'=>$id,
                ]);  
                break;
            default:
            $vendeur = $vendeurRepo->findOneBy([
                'id'=>$id,
            ]);  
            $images = [];
            foreach($vendeur->getOffre() as $val){
                foreach($val->getImages() as $valImg){ 
                    array_push($images,$valImg->getUrl());
                }
                array_push($annonces , [
                    'id'=>$val->getId(),
                    'titre'=>$val->getTitre(),
                    'quartier' => [
                        'nom'=>$val->getQuartier()->getNomQ(),
                        'lat'=> $val->getQuartier()->getLat(),
                        'long'=> $val->getQuartier()->getLog(),
                    ],
                    'ville'=>[
                        'nom' => $val->getQuartier()->getVille()->getNom(),
                        'lat' => $val->getQuartier()->getVille()->getLat(),
                        'long' => $val->getQuartier()->getVille()->getLog(),
                    ],
                    'piece'=> $val->getPiece(),
                    'salleBain' => $val->getNombreSalleBain(),
                    'surface' => $val->getSurface(),
                    'prix' => $val->getPrix(),
                    'images'=>$images ,
                ]);
                
            }
            $res = [
                'id_user'=>$vendeur->getUser()->getId(),
                'nom' => $vendeur->getUser()->getNom(),
                'prenom' => $vendeur->getUser()->getPrenom(),
                'tele' => $vendeur->getUser()->getTelephone(),
                'annonces' => $annonces,
                'imageP'=>($vendeur->getUser()->getImage()) ? $vendeur->getUser()->getImage()->getUrl() : "",
            ];
                break;
        }
        if($vendeur != null){
        $response = $this->json([
            'status'=> 200,
            'Vendeur'=> $res
        ], 200 );
        } else {
        $response = $this->json([
            'status'=> 404,
            'message'=> "Vendeur n'existe pas !"
        ], 404 );
        }
    $response->headers->set('Access-Control-Allow-Origin','*');
    return $response;
    }

    /**
     * @Route("/api/ListeAnnonces", name="ListeAnnonces" , methods={"GET"})
     */
    public function getListAnnonces(OffreRepository $OffreRepo)
    {
        $result = $OffreRepo->findAll();
        if ($result != null) {
            $ListeAnnonces = [];
            $count = 0;
            foreach($result as $val){
                $countImages = 0 ;
                if ($val->getStatue() == "en ligne") {
                $ListeAnnonces[$count]['id'] = $val->getId();
                $ListeAnnonces[$count]['titre'] = $val->getTitre();
                $ListeAnnonces[$count]['description'] = $val->getDescription();
                $ListeAnnonces[$count]['quartier']['nom'] = $val->getQuartier()->getNomQ();
                $ListeAnnonces[$count]['quartier']['lat'] = $val->getQuartier()->getLat();
                $ListeAnnonces[$count]['quartier']['long'] = $val->getQuartier()->getLog();
                $ListeAnnonces[$count]['ville']['nom'] = $val->getQuartier()->getVille()->getNom();
                $ListeAnnonces[$count]['ville']['lat'] = $val->getQuartier()->getVille()->getLat();
                $ListeAnnonces[$count]['ville']['long'] = $val->getQuartier()->getVille()->getLog();
                $ListeAnnonces[$count]['piece'] = $val->getPiece();
                $ListeAnnonces[$count]['salleBain'] = $val->getNombreSalleBain();
                $ListeAnnonces[$count]['surface'] = $val->getSurface();
                $ListeAnnonces[$count]['parking'] = $val->getNombreParking();
                $ListeAnnonces[$count]['verdure'] = $val->getVerdure();
                $ListeAnnonces[$count]['datePublication']['jour'] = $val->getCreateAt()->format('w');
                $ListeAnnonces[$count]['datePublication']['mois'] = $val->getCreateAt()->format('F');
                $ListeAnnonces[$count]['datePublication']['annee'] = $val->getCreateAt()->format('Y');
                $ListeAnnonces[$count]['datePublication']['heur'] = $val->getCreateAt()->format('h');
                $ListeAnnonces[$count]['prix'] = $val->getPrix();
                $ListeAnnonces[$count]['typeImmo'] = $val->getTypeImmobilier()->getId();
                foreach( $val->getImages() as $image){
                    $ListeAnnonces[$count]['images'][$countImages] = $image->getUrl();
                    $countImages ++;
                }
                $count ++;
                } 
            }
            $response = $this->json([
                'status'=> 200,
                'Annonces'=> $ListeAnnonces
            ], 200 );
        } else {
            $response = $this->json([
                'status'=> 404,
                'message'=> "Auccune Annonces n'est disponible pour le moment !"
            ], 404 );
        }
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

     /**
     * @Route("/api/AddUser", name="api_post_index" , methods={"POST"})
     */
    public function AddUser(Request $request ,UserRepository $userRepo,ImagesRepository $imageRepo , EntityManagerInterface $em)
    {
        try{
        $user = new User();
        $user->setDateInscription(new \Datetime());
        $user->setPrenom($request->request->get("prenom"));
        $user->setNom($request->request->get("nom"));
        $user->setEmail($request->request->get("email"));
        $user->setSexe($request->request->get("sexe"));
        $user->setAdresse($request->request->get("adresse"));
        $user->setTypeP($request->request->get("typeP"));
        $hash1 = password_hash($request->request->get("pasword"),PASSWORD_BCRYPT,array('cost' => 11));
        $user->setPassword($hash1);
        $user->setTelephone($request->request->get("telephone"));
        $user->setBanne($request->request->get("banne"));
        if($request->files->get('image') != null){
            $imagedb = new Images();
            $images = $request->files->get('image');
            $file = md5(uniqid()).'.'.$images->getClientOriginalExtension();
            $images->move(
                $this->getParameter('images_directory'),
                $file
            );
            $imagedb->setUrl('/imagesUploadedT/'.$file);
            $em->persist($imagedb);
            $em->flush();
            $imagecreated = $imageRepo->findOneBy([
                "url" => $imagedb->getUrl()
            ]);
            $user->setImage($imagecreated);
        }
        $em->persist($user);
        $em->flush();
        if ($request->request->get("typeP") == 1) {
        //add to tablien client
        $client = new Client();
        $client->setUser($userRepo->findOneBy(["email" => $request->request->get("email")]));
        $em->persist($client);
        $em->flush();
        } else {
           //add to tablien vendeur
           $vendeur = new Vendeur();
           $vendeur->setUser($userRepo->findOneBy(["email" => $request->request->get("email")]));
           $em->persist($vendeur);
           $em->flush();
        }
        
        $response = $this->json([
            'status'=> 201,
            'message'=> "Utilisateur enregistrer",
            'user'=> $user,
            'vendeur'=> ($vendeur != null)? $vendeur : null
        ],201);
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ],400);
        }
    }
}
