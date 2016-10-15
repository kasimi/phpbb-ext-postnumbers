<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * Ελληνική μετάφραση [el]
 *
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'POSTNUMBERS_TITLE'						=> 'Αριθμός Δημοσίευσης',
	'POSTNUMBERS_CONFIG'					=> 'Ρυθμίσεις',
	'POSTNUMBERS_CONFIG_UPDATED'			=> 'Επέκταση <strong>Αριθμός Δημοσίευσης</strong><br />» Οι νέες ρυθμίσεις ενημερώθηκαν',
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Εμφάνιση αριθμού δημοσίευσης στην προβολή θέματος',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Εμφάνιση αριθμού δημοσίευσης στην προεπισκόπιση θέματος κατά τη σύνταξη απάντησης',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Εμφάνιση αριθμού δημοσίευσης στην προεπισκόπιση θέματος στον Πίνακα Ελέγχου Συντονιστών',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Παράκαμψη σε μη εγκεκριμένες δημοσιεύσεις',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Δεν θα αριθμούνται μη εγκεκριμένες και προσωρινά διαγραμμένες δημοσιεύσεις',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Εμφάνιση του ID της δημοσίευσης αντί του αριθμού δημοσίευσης',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Αν ενεργοποιηθεί, η παραπάνω ρύθμιση <span style="font-style: italic;">Παράκαμψη σε μη εγκεκριμένες δημοσιεύσεις</span> θα αγνοηθεί',
	'POSTNUMBERS_LOCATION'					=> 'Θέση εμφάνισης του αριθμού δημοσίευσης',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Μεταξύ του εικονιδίου δημοσίευσης και του ονόματος του συντάκτη',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'Στο θέμα της δημοσίευσης',
	'POSTNUMBERS_CLIPBOARD'					=> 'Αντιγραφή συνδέσμου δημοσίευσης με το πάτημα στον αριθμό δημοσίευσης',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Ισχύει μόνο αν ο αριθμός δημοσίευσης εμφανίζεται μεταξύ του εικονιδίου δημοσίευσης και του ονόματος του συντάκτη. Λειτουργεί μόνο τους ακόλουθους (ή νεώτερων εκδόσεων) browsers: Chrome 42, Firefox 41, IE 9, Opera 29. Ο Safari δεν υποστηρίζεται. Οι μη υποστηριζόμενοι browsers εμφανίζουν ένα παράθυρο που περιέχει το σύνδεσμο της δημοσίευσης.',
	'POSTNUMBERS_BOLD'						=> 'Εμφάνιση του αριθμού δημοσίευσης/ID με έντονους χαρακτήρες',
	'POSTNUMBERS_BOLD_EXP'					=> 'Ισχύει μόνο αν ο αριθμός δημοσίευσης εμφανίζεται μεταξύ του εικονιδίου δημοσίευσης και του ονόματος του συντάκτη.',
));
