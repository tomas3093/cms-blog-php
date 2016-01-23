<?php

//trieda trieda s validacnymi a dalsimi metodami

class Validation
{
    //vrati hodnost uzivatela
    public function returnUserRank($value)
    {
        $rank = '';

        switch($value)
        {
            case 0:
                $rank = 'Člen';
                break;
            case 1:
                $rank = 'Administrátor';
                break;
            case 2:
                $rank = 'Redaktor';
                break;
        }
        return $rank;
    }

    //vrati nazov kategorie
    public function returnCategoryName($value)
    {
        $category = '';

        switch($value)
        {
            case 'novinky':
                $category = 'Novinky';
                break;
            case 'programovanie':
                $category = 'Programovanie';
                break;
            case 'hardware':
                $category = 'Hardware';
                break;
            case 'software':
                $category = 'Software';
                break;
            case 'ostatne':
                $category = 'Ostatné';
                break;
        }
        return $category;
    }

    //overi minimalnu dlzku hesla
    public function checkPasswordLength($password)
    {
        if(strlen($password) < 5)
            throw new UserError('Heslo je príliš krátke. Zadajte aspoň 5 znakov.');
    }

    //vrati status vsetkych clankov (publikovany/nepublikovany)
    public function statusOfArticles($articles = array())
    {
        $step = 0;
        foreach($articles as $article)
        {
            if($article['public'] == '0')
                $articles[$step]['status'] = '<i class="fa fa-eye-slash"></i> Nepublikovaný';
            else
                $articles[$step]['status'] = '<i class="fa fa-eye"></i> Publikovaný';
            $step += 1;
        }
        return $articles;
    }

    //vrati spravny tvar URL adresy
    public function checkUrl($url)
    {
        if(empty($url))
            throw new UserError('Vyplňte titulok!');

        $url = strip_tags($url);                                                    //odstrani HTPL a PHP tagy
        $url = mb_strtolower($url);                                                 //zmeni velke pismena na male
        $url = trim($url);                                                          //odstrani biele znaky
        $url = str_replace(Array(" ", "_"), "-", $url);                             //nahradi medzery a podtrzitka pomlckami
        $url = iconv('utf-8', 'ascii//TRANSLIT', $url);                             //odstrani diakritiku
        $url = str_replace(Array("(",")",".","!","?",",","\"","'",":",";", "/"), "", $url);     //odstrani /().!,"'?:;

        if(strlen($url) > 90)
            throw new UserError('Príliš dlhý titulok!');

        if(strlen($url) < 2)
            throw new UserError('Krátky titulok! Minimálna dĺžka je 2 znaky.');

        return $url;
    }

    //validacia uzivatelskeho mena
    public function checkUsername($username)
    {
        if(empty($username))
            throw new UserError('Zadajte používateľské meno!');

        $username = strip_tags($username);

        //test retazca pomocou regularneho vyrazu (1. musi zacinat pismenom, 2. dlzka 4 - 32 znakov, 3. obsahuje iba pismena a cisla)
        if(!preg_match('/^[A-Za-z][A-Za-z0-9]{3,31}$/', $username))
            throw new UserError('Používateľské meno obsahuje nepovolené znaky alebo je v nesprávnom tvare!');

        return $username;
    }
}