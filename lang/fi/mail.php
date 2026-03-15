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

    // order-status-updated
    'order_status_updated' => [
        // Sähköpostin aiherivit
        'subject_pending'    => 'Tilauksesi odottaa käsittelyä',
        'subject_processing' => 'Tilaustasi käsitellään',
        'subject_completed'  => 'Tilauksesi on valmis!',
        'subject_cancelled'  => 'Tilauksesi on peruutettu',
        'subject_refunded'   => 'Tilauksesi on hyvitetty',

        // Merkintätekstit
        'badge_pending'    => 'Tilaus odottaa',
        'badge_processing' => 'Tilaus käsittelyssä',
        'badge_completed'  => 'Tilaus valmis',
        'badge_cancelled'  => 'Tilaus peruutettu',
        'badge_refunded'   => 'Tilaus hyvitetty',

        // Otsikot
        'heading_pending'    => 'Tilauksesi odottaa käsittelyä',
        'heading_processing' => 'Tilaustasi käsitellään',
        'heading_completed'  => 'Tilauksesi on valmis!',
        'heading_cancelled'  => 'Tilauksesi on peruutettu',
        'heading_refunded'   => 'Hyvityksesi on matkalla',

        // Tilakohtaiset viestit
        'message_pending'    => 'Tilauksesi odottaa käsittelyä. Ilmoitamme sinulle, kun käsittely alkaa.',
        'message_processing' => 'Hyvä uutinen! Tilaustasi käsitellään nyt. Pidämme sinut ajan tasalla.',
        'message_completed'  => 'Loistava uutinen! Tilauksesi on valmis. Kiitos ostoksestasi!',
        'message_cancelled'  => 'Tilauksesi on peruutettu. Jos sinulla on kysyttävää, ota rohkeasti yhteyttä meihin.',
        'message_refunded'   => 'Hyvityksesi on käynnistetty. Odota muutamia pankkipäiviä, ennen kuin summa näkyy tililläsi.',

        // Tilanimet (käytetään tila-muutosrivillä)
        'status_pending'    => 'Odottaa',
        'status_processing' => 'Käsittelyssä',
        'status_completed'  => 'Valmis',
        'status_cancelled'  => 'Peruutettu',
        'status_refunded'   => 'Hyvitetty',

        // Yhteiset
        'hi'               => 'Hei',
        'order_number'     => 'Tilausnumero',
        'status_updated'   => 'Tilapäivitys',
        'previous_status'  => 'Edellinen tila',
        'new_status'       => 'Uusi tila',
        'order_summary'    => 'Tilauksen yhteenveto',
        'col_product'      => 'Tuote',
        'col_qty'          => 'Määrä',
        'col_total'        => 'Yhteensä',
        'order_total'      => 'Tilauksen kokonaissumma',
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
