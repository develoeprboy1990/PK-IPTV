<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_order_no_column extends CI_Migration {

    public function up() {
        $fields = array(
            'order_no' => array(
                'type' => 'INT',
                'null' => TRUE,
                'default' => 0,
                'after' => 'id'
            )
        );

        // Add order_no column to movie_genre table
        if (!$this->db->field_exists('order_no', 'movie_genre')) {
            $this->dbforge->add_column('movie_genre', $fields);
        }

        // Add order_no column to movie_ott_platforms table
        if (!$this->db->field_exists('order_no', 'movie_ott_platforms')) {
            $this->dbforge->add_column('movie_ott_platforms', $fields);
        }

        // Add order_no column to series_ott_platforms table
        if (!$this->db->field_exists('order_no', 'series_ott_platforms')) {
            $this->dbforge->add_column('series_ott_platforms', $fields);
        }

        // Add order_no column to tv_show_platforms table
        if (!$this->db->field_exists('order_no', 'tv_show_platforms')) {
            $this->dbforge->add_column('tv_show_platforms', $fields);
        }
    }

    public function down() {
        // Drop order_no column from movie_genre table
        if ($this->db->field_exists('order_no', 'movie_genre')) {
            $this->dbforge->drop_column('movie_genre', 'order_no');
        }

        // Drop order_no column from movie_ott_platforms table
        if ($this->db->field_exists('order_no', 'movie_ott_platforms')) {
            $this->dbforge->drop_column('movie_ott_platforms', 'order_no');
        }

        // Drop order_no column from series_ott_platforms table
        if ($this->db->field_exists('order_no', 'series_ott_platforms')) {
            $this->dbforge->drop_column('series_ott_platforms', 'order_no');
        }

        // Drop order_no column from tv_show_platforms table
        if ($this->db->field_exists('order_no', 'tv_show_platforms')) {
            $this->dbforge->drop_column('tv_show_platforms', 'order_no');
        }
    }
}