## Introduction

Le BHSeoBundle est conçu de manière à ce qu’on puisse facilement gérer les titles et description pour le référencement des sites développés sous Symfony. 

Ce Back Office n'est accessible que pour un utilisateur ayant un ROLE_SEO.

### Prérequis
    FosUserBundle
    BackBundle


## Installation

### Activer BHSeoBundle dans le Kernel

    // app/AppKernel.php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = [
                // ...
                new BH\SeoBundle\BHSeoBundle()
        }
    }


### Mettre à jour le schéma de base de données

    php bin/console doctrine:schema:update --force

    
### Importer les fichiers de routing

    # // app/config/routing.yml
    # ...
    bh_seo:
        resource: "@BHSeoBundle/Resources/config/routing.yml"
        prefix:   /admin_seo


    # ...

### Modifier le title et la description par défaut dans la template seo.html.twig
    {# src/BH/SeoBundle/Resources/views/seo/seo.html.twig #}


### Ajouter le render(controller) dans le  <head> du layout de base

    {# app/Resources/views/base.html.twig #}
    <!DOCTYPE html>
    <html lang="fr">
      <head>
        ...
        {{  render(controller('BHSeoBundle:Seo:getSeo', { 'url': app.request.pathInfo } )) }}
        ...
### SeoBundle nécessite Jquery, bootstrap et datatable : Ajouter dans layout de base

    {# app/Resources/views/base.html.twig #}
    <!DOCTYPE html>
    <html lang="fr">
        ...
        {% block stylesheets %}
        ...
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
        ...
        {% endblock %}
        ...
        
    {% block javascripts %}
    ...
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
    ...
    {% endblock %}
    
 ### Exemple d'accès via votre menu 
 
     {% if is_granted('ROLE_SEO') %}
        <li class="dropdown {{ 'admin_seo' in app.request.attributes.get('_route') ? 'active' }}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SEO et URL <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ path("admin_seo") }}">Liste</a></li>
                <li><a href="{{ path("admin_seo_add") }}">Ajouter</a></li>
            </ul>
        </li>

    {% endif %}
    
  ### Créer l'admin seo
  
    php bin/console fos:user:create
    
  ### Ajouter le ROLE_SEO à l'admin seo
  
    php bin/console fos:user:promote