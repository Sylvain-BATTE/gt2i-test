<?php 

class modulemail extends Module {


    public function __construct() {
        $this->name = 'moduleMail'; // Doit correspondre au nom du module, dans notre cas : monmodule
        $this->tab = 'emailing'; // Correspond à l'onglet de catégorisation du module, pour tous les connaitre : https://devdocs.prestashop.com/1.7/modules/creation/
        $this->version = '1.0'; // Version actuelle du module
        $this->author = 'Sylvain Batte'; // L'auteur
        $this->ps_versions_compliancy = array( // Permet de limiter les versions compatibles
            'min' => '1.7',
            'max' => _PS_VERSION_
        );
        parent::__construct();
    
        $this->displayName = $this->l('Module Mail'); // Nom d'affichage
        $this->description = $this->l('Envoie un mail à chaque modification de quantité d\'un produit'); // Description du module
        $this->confirmUninstall = $this->l('Êtes-vous sûr de vouloir désinstaller ce module ?');
    }

    public function install() {
        $this->registerHook('actionUpdateQuantity');

        if (parent::install()) {
            return true;
        }
        return false;
    }
 
    public function uninstall() {
        if (parent::uninstall()) {
            return true;
        }
        return false;
    }

    public function hookActionUpdateQuantity($params) {
        $id_product = $params["id_product"];
        $quantity = $params["quantity"];

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