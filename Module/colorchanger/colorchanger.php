<?php
/* vérification si le code est bien exécuter sur prestashop*/
if (!defined('_PS_VERSION_')) {
    exit;
}

class ColorChanger extends Module
{
    /*constructeur pour initialiser les paramètres*/
    public function __construct()
    {
        $this->name = 'colorchanger';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Lohan Levis';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Manager les couleures');
        $this->description = $this->l('Modifier les couleures du header, body et footer depuis la partie admin.');
    }

    /* initialisation des valeures des différentes couleures de ABL*/
    public function install()
    {
        return parent::install() && 
               $this->registerHook('header') &&
               Configuration::updateValue('COULEUR_HEADER', '#FFFFFF') &&
               Configuration::updateValue('COULEUR_BODY', '#F4F5F8') &&
               Configuration::updateValue('COULEUR_FOOTER', '#222429');
    }

    /* fonction utilie pour la suppresion du module sans quoi la page admin module ne fonctionne plus*/
    public function uninstall()
    {
        return parent::uninstall() &&
               Configuration::deleteByName('COULEUR_HEADER') &&
               Configuration::deleteByName('COULEUR_BODY') &&
               Configuration::deleteByName('COULEUR_FOOTER');
    }

    /* récupération de toutes les informations de la page pour le module*/
    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submit' . $this->name)) {
            Configuration::updateValue('COULEUR_HEADER', Tools::getValue('COULEUR_HEADER'));
            Configuration::updateValue('COULEUR_BODY', Tools::getValue('COULEUR_BODY'));
            Configuration::updateValue('COULEUR_FOOTER', Tools::getValue('COULEUR_FOOTER'));
            $output .= $this->displayConfirmation($this->l('Modifications enregistrées'));
        }

        return $output . $this->renderForm();
    }
    /* rendering du formulaire d'intération admin*/
    protected function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Modifier les couleures'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'color',
                        'label' => $this->l('Couleur du Header'),
                        'name' => 'COULEUR_HEADER',
                        'size' => 20,
                        'desc' => $this->l('Modifier la couleur du Header.'),
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Couleur du Body'),
                        'name' => 'COULEUR_BODY',
                        'size' => 20,
                        'desc' => $this->l('Modifier la couleur du Body.'),
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Couleur du Footer'),
                        'name' => 'COULEUR_FOOTER',
                        'size' => 20,
                        'desc' => $this->l('Modifier la couleur du Footer.'),
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit' . $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        /*la dernière ligne vérifie bien qu'un admin réalise l'action*/
        $helper->fields_value['COULEUR_HEADER'] = Configuration::get('COULEUR_HEADER');
        $helper->fields_value['COULEUR_BODY'] = Configuration::get('COULEUR_BODY');
        $helper->fields_value['COULEUR_FOOTER'] = Configuration::get('COULEUR_FOOTER');

        return $helper->generateForm([$fields_form]);
    }
    /*modification des couleures de la page si modification il y a eut*/
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/custom.css', 'all');
        $headerColor = Configuration::get('COULEUR_HEADER');
        $bodyColor = Configuration::get('COULEUR_BODY');
        $footerColor = Configuration::get('COULEUR_FOOTER');
        $css = "
            <style>
                header { background-color: $headerColor !important; }
                body { background-color: $bodyColor !important; }
                footer { background-color: $footerColor !important; }
            </style>
        ";
        return $css;
        /* utilisation du !important pour overwrite les style pré-*définis*/

    }
}
