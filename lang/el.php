<?php

$data = array(
    "/" => array (
        "title"
        => "OmnesViae: Ρωμαϊκός Σχεδιαστής Διαδρομών",
        "description"
        => "Σχεδιάστε το ταξίδι σας σαν ένας Ρωμαίος, με έναν σχεδιαστή διαδρομών βασισμένο στις ρωμαϊκές πηγές, τον χάρτη δρόμων Tabula Peutingerina και τον οδηγό ταξιδιού του Αντωνίνου.",
        "keywords"
        => "Ρωμαϊκός σχεδιαστής διαδρομών, ρωμαϊκός χάρτης δρόμων, Tabula Peutingeriana, Itinerarium Antonini, ρωμαϊκός οδηγός ταξιδιού, ρωμαϊκή διαδρομή ταξιδιού, ρωμαϊκοί δρόμοι, ρωμαϊκός χάρτης δρόμων, ρωμαϊκός σχεδιαστής δρόμων, ρωμαϊκή διαδρομή δρόμων, ρωμαϊκός σχεδιαστής διαδρομής δρόμων, itinerarium, Αντωνίνος"
    ),
    "/tabula" => array (
        "title"
        => "OmnesViae: Tabula Peutingeriana",
        "description"
        => "Δείτε την Tabula Peutingeriana, ένα μεσαιωνικό αντίγραφο ενός μακρύς ρωμαϊκού χάρτη δρόμων της Ρωμαϊκής Αυτοκρατορίας.",
        "keywords"
        => "Tabula Peutingeriana, IIIF, ρωμαϊκός χάρτης δρόμων, ρωμαϊκοί δρόμοι, ρωμαϊκός χάρτης δρόμων",
        "credits"
        => "Επεξεργασία Tabula Peutingeriana από <a href='https://www.ku.de/ggf/geschichte/alte-geschichte/forschung/datenbank-tp-online'>Datenbank tp-online</a>"
    ),
    "/nobis" => array (
        "title" => "Ο Σχεδιαστής Διαδρομών OmnesViae",
        "description" => "Σχετικά με το OmnesViae.org και τη χρήση του ιστότοπου.",
        "keywords" => "OmnesViae, χρήση, παρασκήνιο, δημιουργοί, δικαιώματα, δωρεές, github, René Voorburg",
        "intro" => "Το OmnesViae είναι ένας <a href=\"/\">σχεδιαστής διαδρομών για τη Ρωμαϊκή Αυτοκρατορία</a>, βασισμένος σε ιστορικά δεδομένα. Η κύρια πηγή του είναι μια (μεσαιωνική αντιγραφή μιας) ρωμαϊκής χάρτης, γνωστή ως η <a href=\"/tabula\">Tabula Peutingeriana</a> (TP), η οποία δείχνει το <em>cursus publicus</em>, το δίκτυο δρόμων της Ρωμαϊκής Αυτοκρατορίας. Επειδή ο δυτικότερος μέρος του χάρτη έχει χαθεί, οι τοποθεσίες και οι διαδρομές σε αυτό το μέρος της αυτοκρατορίας προέρχονται από το <em>Αντωνινικό Ιτινεράριο</em> (Itinerarium Antonini).<br />Η συντομότερη διαδρομή υπολογίζεται χρησιμοποιώντας τις αποστάσεις που αναφέρονται σε αυτές τις αρχαίες πηγές.",
        "subtitle" => "πλοηγηθείτε στη Ρωμαϊκή Αυτοκρατορία",
        "donate" => "Το OmnesViae είναι δωρεάν για χρήση, αλλά αν σας αρέσει, παρακαλώ σκεφτείτε να μου αγοράσετε έναν καφέ.",
        "participate" => "συμμετοχή",
        "datasource" => "Η πηγή δεδομένων για τον σχεδιαστή διαδρομών και το εμφανιζόμενο δίκτυο δρόμων είναι ένα αρχείο JSON-LD στο <a href=\"/data/omnesviae.json\">https://omnesviae.org/data/omnesviae.json</a>. Μπορείτε να κατεβάσετε αυτό το αρχείο, να το επεξεργαστείτε για να ταιριάζει με την ερμηνεία σας της TP, και στη συνέχεια να το φορτώσετε στο OmnesViae δείχνοντας την παράμετρο <strong>?datasource</strong> προς αυτό. Για παράδειγμα, χρησιμοποιήστε <a href=\"/?datasource=https://omnesviae.org/data/omnesviae.json\">https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json</a>, για να φορτώσετε τον προεπιλεγμένο ορισμό. Δείτε <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> για περισσότερες πληροφορίες.",
        "sourcecode" => "Ο πηγαίος κώδικας του OmnesViae είναι διαθέσιμος στο <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> υπό μια άδεια ανοιχτού κώδικα.",
        "credits" => "Το OmnesViae δημιουργήθηκε από τον <a href=\"https://www.linkedin.com/in/rené-voorburg-aa54a93/\">René Voorburg</a>.
            Τα περισσότερα δεδομένα πίσω από το OmnesViae βασίζονται στην επιστημονική εργασία του Richard Talbert σχετικά με το TP, <a href=\"https://www.cambridge.org/us/talbert/\">Rome's World: The Peutinger Map Reconsidered</a>.
            Η ταυτοποίηση των τοποθεσιών των τόπων βασίζεται κατά κύριο λόγο σε δεδομένα από το <a href=\"http://pleiades.stoa.org/\">Έργο Pleiades</a> και στην εργασία του Martin Weber <a href=\"https://tabula-peutingeriana.de/\">Tabvla Pevtingeriana</a>. Μια πολύτιμη πηγή για την έρευνα στην Tabula είναι η <a href='https://www.ku.de/ggf/geschichte/alte-geschichte/forschung/datenbank-tp-online'>Datenbank tp-online</a>.<br />
            Το OmnesViae προσθέτει μερικές συνδέσεις πάνω από τη θάλασσα που δεν εμφανίζονται στο TP (αναγνωρίζονται από τις διακεκομμένες γραμμές).<br />
            Πολλοί βοήθησαν στις μεταφράσεις στην πρώτη έκδοση του OmnesViae, που υπήρχε από το 2011 έως το 2024.
            Αυτή η έκδοση του OmnesViae είναι μια πλήρης επανεγγραφή της αρχικής.
            Χρησιμοποιήθηκε υποστήριξη από εργαλεία AI για την εικονογράφηση σε αυτή τη σελίδα και τις μεταφράσεις."
    )
);
