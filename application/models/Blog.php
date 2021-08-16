<?php
// ------------------------------------------------------------------------
// $Id: $
// ------------------------------------------------------------------------


require_once ('Blog/Category.php');
require_once ('Blog/Entry.php');
require_once ('Blog/Comment.php');

// ------------------------------------------------------------------------
// class: Blog
// ------------------------------------------------------------------------
// Represents a web log
// ------------------------------------------------------------------------
class Blog
{
    var $id; // Numeric blog ID
    var $user_id; // User ID of the owner
    var $title; // Title of the log
    var $description; // Brief description
    var $authors; // Authors allowed to edit this blog
    var $categories; // Sub categories of the blog
    var $entries; // Array of Blog_Entry objects

    
    // --------------------------------------------------------------------
    // Constructor
    // --------------------------------------------------------------------
    function Blog($id = 0, $row = array())
    {
        global $db;
        $this->authors = array();
        $this->categories = array();
        $this->entries = array();
        
        if ($id) {
            $sql = "SELECT * FROM blog
					WHERE id = $id";
            
            $db->query_exec($sql);
            
            if ($db->rc == 1)
                $row = $db->rs[0];
        }
        if ($row) {
            $this->id = $row[id];
            $this->user_id = $row[user_id];
            $this->title = $row[title];
            $this->description = $row[description];
        }
    }

    function insert()
    {
        global $db;
        
        $sql = "INSERT INTO blog
				VALUES (null,
				$this->user_id,
				'" . DB::encode($this->title) . "',
				'" . DB::encode($this->description) . "'
				)";
        
        $db->query_exec($sql);
        
        $this->id = $db->get_insert_id();
        
        return $db->rc;
    }

    function update()
    {
        global $db;
        
        $sql = "UPDATE blog SET
				user_id = $this->user_id,
				title = '" . DB::encode($this->title) . "',
				description = '" . DB::encode($this->description) . "'
				WHERE id = $this->id";
        
        $db->query_exec($sql);
        
        return $db->rc;
    }

    function delete()
    {
        global $db;
        
        $sql = "DELETE FROM blog
				WHERE id = $this->id";
        
        $db->query_exec($sql);
        
        return $db->rc;
    }

    function get_authors()
    {
        global $db;
        $this->authors = array();
        
        $sql = "SELECT * FROM blog_author
				WHERE blog_id = $this->id";
        
        $db->query_exec($sql);
        
        foreach ($db->rs as $row)
            $this->authors[] = new User($row[user_id]);
    }

    function get_categories()
    {
        global $db;
        $this->categories = array();
        
        $sql = "SELECT * FROM blog_category
				WHERE blog_id = $this->id";
        
        $db->query_exec($sql);
        
        foreach ($db->rs as $row)
            $this->categories[] = new Blog_Category(0, $row);
    }

    function get_entries($args = array())
    {
        global $db;
        $this->entries = array();
        
        $sql = "SELECT * FROM blog_entry
				WHERE blog_id = $this->id ";
        $sql .= ($args[after] ? "AND creation_date > '" . $args[after] . "' " : '');
        $sql .= ($args[status] ? "AND status = '" . $args[status] . "' " : '');
        $sql .= "ORDER BY creation_date " . ($args[order] ? "$args[order] " : 'DESC ');
        $sql .= ($args[limit] ? 'LIMIT ' . $args[limit] . ' ' : '');
        
        $db->query_exec($sql);
        
        foreach ($db->rs as $row)
            $this->entries[] = new Blog_Entry(0, $row);
    }

    function get_num_entries()
    {
        global $db;
        
        $result = 0;
        $this->get_categories();
        
        foreach ($this->categories as $category)
            $result += $category->get_num_entries();
        
        return $result;
        ;
    }
    
// ------------------------------------------------
// Static/Class functions
// ------------------------------------------------
}
