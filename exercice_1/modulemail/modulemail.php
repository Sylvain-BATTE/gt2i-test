<?php 

class modulemail extends Module {

    // Contructeur du module contenant les différentes informations de celui-ci
    public function __construct() {
        $this->name = 'moduleMail'; 
        $this->tab = 'emailing'; 
        $this->version = '1.0'; 
        $this->author = 'Sylvain Batte'; 
        $this->ps_versions_compliancy = array( 
            'min' => '1.7',
            'max' => _PS_VERSION_
        );
        parent::__construct();
    
        $this->displayName = $this->l('Module Mail'); 
        $this->description = $this->l('Envoie un mail à chaque modification de quantité d\'un produit'); 
        $this->confirmUninstall = $this->l('Êtes-vous sûr de vouloir désinstaller ce module ?');
    }

    // Fonction d'installation
    public function install() {
        $this->registerHook('actionUpdateQuantity'); // On installe le module

        if (parent::install()) {
            return true;
        }
        return false;
    }
 
    // Fonction de désinstallation 
    public function uninstall() {
        if (parent::uninstall()) {
            return true;
        }
        return false;
    }

    // Hook permettant de faire fonctionner le module
    public function hookActionUpdateQuantity($params) {

        // On récupère les différents attributs du produit modifié
        $id_product = $params["id_product"];
        $quantity = $params["quantity"];

        // Fonction permettant d'envoyer un mail
        Mail::send(
            (int)(Configuration::get('PS_LANG_DEFAULT')),
            'contact',
            'Modification du produit ' . $id_product,
            array(
                '{email}' => Configuration::get('PS_SHOP_EMAIL'), 
                '{message}' => 'La quantité du produit ' . $id_product . ' a été modifié, et sa quantité est maintenant de : ' . $quantity
            ),
            Configuration::get('PS_SHOP_EMAIL'), 
            NULL, 
            NULL, 
            NULL  
        );
    }

}

?>