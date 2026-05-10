CREATE TABLE tx_maicanteen_menuplan (
    title varchar(255) DEFAULT '' NOT NULL,
    week_start int(11) unsigned DEFAULT '0' NOT NULL,
    week_end int(11) unsigned DEFAULT '0' NOT NULL,
    is_template tinyint(1) unsigned DEFAULT '0' NOT NULL,
    template_week int(11) unsigned DEFAULT '0' NOT NULL,
    notes text
);

CREATE TABLE tx_maicanteen_dish (
    menu_plan int(11) unsigned DEFAULT '0' NOT NULL,
    day_of_week tinyint(1) unsigned DEFAULT '1' NOT NULL,
    sort_order tinyint(3) unsigned DEFAULT '0' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    price varchar(20) DEFAULT '' NOT NULL,
    allergens varchar(255) DEFAULT '' NOT NULL,
    additives varchar(255) DEFAULT '' NOT NULL,
    is_vegetarian tinyint(1) unsigned DEFAULT '0' NOT NULL,
    is_vegan tinyint(1) unsigned DEFAULT '0' NOT NULL,
    is_gluten_free tinyint(1) unsigned DEFAULT '0' NOT NULL
);
