<?php

return [

    // account-deleted
    'account_deleted' => [
        'badge'           => 'Tili poistettu',
        'goodbye'         => 'Näkemiin, ',
        'subtitle'        => config('app.name').'-tilisi on poistettu pysyvästi.',
        'deleted_account' => 'Poistettu tili',
        'account_email'   => 'Tilin sähköposti',
        'what_it_means'   => 'Mitä tämä tarkoittaa',
        'data_removed'    => 'Kaikki henkilökohtaiset tietosi on poistettu pysyvästi järjestelmistämme.',
        'no_login'        => 'Et voi enää kirjautua sisään tällä tilillä.',
        'warning'         => '<strong>Etkö pyytänyt tätä?</strong> Jos uskot, että tili poistettiin vahingossa, ota yhteyttä tukitiimiimme välittömästi.',
        'thank_you'       => 'Kiitos, että olit osa '.config('app.name').':a.',
        'see_you'         => 'Toivottavasti nähdään vielä! Pidä huolta! 💜',
        'all_rights'      => 'Kaikki oikeudet pidätetään.',
    ],

    // google-welcome
    'google_welcome' => [
        'badge'          => 'Google-kirjautuminen',
        'welcome'        => 'Tervetuloa, ',
        'subtitle'       => "Olet kirjautunut sisään Googlella.\n".config('app.name').'-tilisi on valmis.',
        'your_account'   => 'Tilisi',
        'email_label'    => 'Sähköposti',
        'sign_in_method' => 'Kirjautumistapa',
        'sign_in_info'   => 'Voit kirjautua sisään milloin tahansa Google-tililläsi. Salasanaa ei tarvita.',
        'need_help'      => 'Tarvitsetko apua?',
        'need_help_body' => 'Vastaa tähän sähköpostiin, niin tiimimme auttaa sinua mielellään.',
        'all_rights'     => 'Kaikki oikeudet pidätetään.',
    ],

    // order-confirmation
    'order_confirmation' => [
        'badge'            => 'Tilausvahvistus',
        'heading'          => 'Kiitos tilauksestasi!',
        'hi'               => 'Hei',
        'greeting'         => ', tilauksesi on vastaanotettu ja sitä käsitellään.',
        'order_number'     => 'Tilausnumero',
        'customer'         => 'Asiakas',
        'billing_address'  => 'Laskutusosoite',
        'shipping_address' => 'Toimitusosoite',
        'order_summary'    => 'Tilauksen yhteenveto',
        'col_product'      => 'Tuote',
        'col_qty'          => 'Määrä',
        'col_price'        => 'Hinta',
        'col_total'        => 'Yhteensä',
        'order_total'      => 'Tilauksen kokonaissumma',
        'order_notes'      => 'Tilauksen muistiinpanot',
        'questions'        => 'Kysyttävää tilauksestasi?',
        'questions_body'   => 'Vastaa tähän sähköpostiin, niin autamme sinua mielellään.',
        'all_rights'       => 'Kaikki oikeudet pidätetään.',
    ],

    // registration-welcome
    'registration_welcome' => [
        'badge'           => 'Uusi tili',
        'heading'         => 'Tervetuloa '.config('app.name').'!',
        'subtitle'        => 'Olemme iloisia, että olet mukana. Tilisi on valmis ja käyttövalmis.',
        'account_details' => 'Tilisi tiedot',
        'email_username'  => 'Sähköposti / Käyttäjätunnus',
        'need_help'       => 'Tarvitsetko apua?',
        'need_help_body'  => 'Vastaa tähän sähköpostiin, niin tiimimme auttaa sinua mielellään.',
        'all_rights'      => 'Kaikki oikeudet pidätetään.',
    ],

];
