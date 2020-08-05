<?php
class acf_vc_helper {

  public function text($field, $acf_version) {
    return $field["value"];
  }

  public function textarea($field, $acf_version) {
    return $field["value"];
  }

  public function wysiwyg($field, $acf_version) {
    return $field["value"];
  }

  public function number($field, $acf_version) {
    return $field["value"];
  }

  public function email($field, $acf_version) {
    return $field["value"];
  }

  public function password($field, $acf_version) {
    return $field["value"];
  }


  public function image($field, $acf_version) {
    $img_details = $field["value"];
    if($acf_version >= 5) {
      if($field["return_format"] == "array") {
        if(isset($img_details["url"])) {
          $output = '<img title="'.$img_details["title"].'" src="'.$img_details["url"].'" alt="'.$img_details["alt"].'" width="'.$img_details["width"].'" height="'.$img_details["height"].'" />';
        } else {
          $output = 'data-mismatch';
        }
      } elseif ($field["return_format"]=="url") {
        $output = '<img src="'.$img_details.'"/>';
      } elseif ($field["return_format"]=="id") {
        $img_details = wp_get_attachment_image_src($img_details);
        $output = '<img src="'.$img_details[0].'"/>';
      } else {
        $output = $field["value"];
      }
    } else {
      if($field["save_format"] == "object" ) {
      	if(isset($img_details["url"])) {
      		$output = '<img title="'.$img_details["title"].'" src="'.$img_details["url"].'" alt="'.$img_details["alt"].'" width="'.$img_details["width"].'" height="'.$img_details["height"].'" />';
      	} else {
      		$output = 'data-mismatch';
      	}
      } elseif ($field["save_format"]=="url") {
        $output = '<img src="'.$img_details.'"/>';
      } elseif ($field["save_format"]=="id") {
        $img_details = wp_get_attachment_image_src($img_details);
        $output = '<img src="'.$img_details[0].'"/>';
      } else {
        $output = $field["value"];
      }
    }
    return $output;
  }

  public function file($field, $acf_version, $link_text) {
    $file_details = $field["value"];
    if($acf_version >= 5) {
      if($field["return_format"] == "array" ) {
        if(isset($file_details["url"])) {
          $output = '<a title="Download '.$file_details["title"].'" href="'.$file_details["url"].'">'.$link_text.'</a>';
        } else {
          $output = 'data-mismatch';
        }
      } elseif ($field["return_format"]=="url") {
        $output = '<a title="Download" href="'.$file_details.'">'.$link_text.'</a>';
      } elseif ($field["return_format"]=="id") {
        $file_details = wp_get_attachment_url($file_details);
        $output = '<a title="Download" href="'.$file_details.'">'.$link_text.'</a>';
      } else {
        $output = $field["value"];
      }
    } else {
      if($field["save_format"] == "object" ) {
      	if(isset($file_details["url"])) {
      		$output = '<a title="Download '.$file_details["title"].'" href="'.$file_details["url"].'">'.$link_text.'</a>';
      	} else {
      		$output = 'data-mismatch';
      	}
      } elseif ($field["save_format"]=="url") {
        $output = '<a title="Download" href="'.$file_details.'">'.$link_text.'</a>';
      } elseif ($field["save_format"]=="id") {
        $file_details = wp_get_attachment_url($file_details);
        $output = '<a title="Download" href="'.$file_details.'">'.$link_text.'</a>';
      } else {
        $output = $field["value"];
      }
    }
    return $output;
  }

  public function select($field, $acf_version) {
    if ( $field["multiple"] === 1 ) {
      if ( !empty($field["value"]) ) {
        $output = '<ul>';
        foreach ($field["value"] as $key => $value) {
            $output .= '<li class="'.$field["name"].' '.$field["name"].'_'.$key.'">'.$value.'</li>';
        }
        $output .= '</ul>';
      }
    } else {
      $output =  $field["value"];
    }
    return $output;
  }

  public function checkbox($field, $acf_version) {
    $check_values = $field["value"];
    if(is_array($check_values)) {
      $output = implode(", ", $check_values);
    } else {
      $output = '';
    }
    return $output;
  }

  public function radio($field, $acf_version) {
    $radio_value = $field["value"];
    $output = $radio_value;
    return $output;
  }

  public function user($field, $acf_version) {
    $user_details = $field["value"];
    if (array_key_exists("field_type",$field))  {
      if ($field["field_type"]=="multi_select") {
        $output = "<ul>";
          foreach ($user_details as $key => $value) {
            $output .= "<li>".$value["display_name"]."</li>";
          }
        $output .= "</ul>";
      } else {
        $output = $user_details["display_name"];
      }
    } elseif (array_key_exists("multiple",$field)) {
      if ($field["multiple"]==1) {
        $output = "<ul>";
          foreach ($user_details as $key => $value) {
            $output .= "<li>".$value["display_name"]."</li>";
          }
        $output .= "</ul>";
      } else {
        $output = $user_details["display_name"];
      }
    }
    return $output;
  }

  public function page_link($field, $acf_version, $link_text) {
    $page_link = $field["value"];
    if ($field["multiple"] == 1) {
      $output = "<ul>";
        foreach ($page_link as $key => $value) {
          $output .= '<li><a title="'.$value.'" href="'.$value.'">'.$link_text.'</a></li>';
        }
      $output .= "</ul>";
    } else {
      $output = '<a title="'.$page_link.'" href="'.$page_link.'">'.$link_text.'</a>';
    }
    return $output;
  }

  public function google_map($field, $acf_version) {
    $map_details = $field["value"];
    $output = '<iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q='.$map_details["lat"].','.$map_details["lng"].'&hl=es;z=14&amp;output=embed"></iframe>';
    return $output;
  }

  public function date_picker($field, $acf_version) {
    $unixtimestamp = strtotime($field["value"]);
    $site_format = get_option( 'date_format' );
    $output = date_i18n($site_format,$unixtimestamp);
    return $output;
  }

  public function color_picker($field, $acf_version) {
    $output = '<div style="display: inline-block; height: 15px; width: 15px; margin: 0px 5px 0px 0px; background-color: '.$field["value"].'"></div>'.$field["value"];
    return $output;
  }

  public function true_false($field, $acf_version) {
    if(1 == $field["value"]) $output = 'True'; else $output = "False";
    return $output;
  }

  public function taxonomy($field, $acf_version) {
    $terms = $field["value"];
      if(!empty($terms)) {
        if ($field["field_type"]=="checkbox" OR $field["field_type"]=="multi_select") {
        $output = "<ul>";
        foreach($terms as $term) {
          $term_details = get_term( $term, 'category', ARRAY_A );
          $output .= '<li><a href="'.get_term_link( $term_details["term_id"], 'category' ).'" title="'.$term_details["name"].'">'.$term_details["name"].'</a></li>';
        }
        $output .= "</ul>";
      } elseif ($field["field_type"]=="radio" OR $field["field_type"]=="select") {
        $term_details = get_term( $terms, 'category', ARRAY_A );
        $output = '<a href="'.get_term_link( $term_details["term_id"], 'category' ).'" title="'.$term_details["name"].'">'.$term_details["name"].'</a>';
      }
    }
    return $output;
  }

  public function post_object($field, $acf_version) {
    $post_obj = $field["value"];
    $output = "<ul>";
    if (is_array($post_obj)) {
      foreach($post_obj as $post_obj_details) {
        if (array_key_exists("return_format",$field))  {
          if ($field["return_format"]=="id") {
            $post_id = $post_obj_details;
          } else {
            $post_id = $post_obj_details->ID;
          }
        } else {
          $post_id = $post_obj_details;
        }
        $output .= '<li><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a></li>';
      }
    } else {
      $output .= '<li><a href="'.get_permalink($post_obj).'" title="'.get_the_title($post_obj).'">'.get_the_title($post_obj).'</a></li>';
    }
    $output .= "</ul>";
    return $output;
  }

  public function relationship($field, $acf_version) {
    $posts = $field["value"];
    $output = "<ul>";
    foreach($posts as $post_details) {
    if ($field["return_format"]=="id") {
      $post_id = $post_details;
    } else {
      $post_id = $post_details->ID;
    }
      $output .= '<li><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a></li>';
    }
    $output .= "</ul>";
    return $output;
  }

  public function url($field, $acf_version) {
    $url = $field["value"];
      $output .= '<a href="'.$url.'">'.$url.'</a>';
      return $output;
  }

  public function oembed($field, $acf_version) {
      return $field["value"];
  }

  public function repeater($field, $acf_version, $link_text, $post_id) {

    $output = '<div class="reapeter-column '.$field["key"].' '.$field["name"].'">';
      if ( 'text' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::text($field, $acf_version);
        }
      } elseif ( 'textarea' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::textarea($field, $acf_version);
        }
      } elseif ( 'wysiwyg' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::wysiwyg($field, $acf_version);
        }
      } elseif ( 'number' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::number($field, $acf_version);
        }
      } elseif ( 'email' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::email($field, $acf_version);
        }
      } elseif ( 'password' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::password($field, $acf_version);
        }
      } elseif ( 'image' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::image($field, $acf_version);
        }
      } elseif('file' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::file($field, $acf_version, $link_text);
        }
			} elseif ( 'select' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::select($field, $acf_version);
        }
      } elseif ( 'checkbox' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::checkbox($field, $acf_version);
        }
			} elseif ( 'radio' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::radio($field, $acf_version);
        }
			} elseif ( 'user' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::user($field, $acf_version);
        }
			} elseif ( 'page_link' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::page_link($field, $acf_version, $link_text);
        }
			} elseif ( 'google_map' === $field["type"] ) {
        if ( !empty($field["value"]) ) {
          $output .= self::google_map($field, $acf_version);
        }
			} elseif ('date_picker' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::date_picker($field, $acf_version);
        }
      } elseif ('color_picker' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::color_picker($field, $acf_version);
        }
      } elseif ('true_false' === $field["type"]) {
          $output .= self::true_false($field, $acf_version);
      } elseif ('taxonomy' === $field["type"]) {
          $output .= self::taxonomy($field, $acf_version);
      } elseif('post_object' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::post_object($field, $acf_version);
        }
			} elseif('relationship' === $field["type"]) {
        if ( !empty($field["value"]) ) {
          $output .= self::relationship($field, $acf_version);
        }
			} elseif('url' === $field["type"]) {
        $output .= self::url($field, $acf_version);
			} elseif('oembed' === $field["type"]) {
        $output .= self::oembed($field, $acf_version);
			}  elseif('repeater' === $field["type"]) {
        if (!empty($field['value'][0])) :
          $fieldNames = array_keys($field['value'][0]);
          $output .= '<div class="repeater-child-wrapper">';
          if ($acf_version >= 5) :
            while ( have_rows($field['name'],$post_id) ) : the_row();
              $output .= '<div class="reapeater-row row-'.get_row_index().'">';
              foreach ($fieldNames as $key => $value) {
              $subSeild = get_sub_field_object($value);
                $subSeildValue = get_sub_field($value);
                $subSeild["value"] = $subSeildValue;
                $output .= self::repeater($subSeild, $acf_version, $link_text, $post_id);
              }
              $output .= '</div>';
            endwhile;
          else :
            while ( has_sub_field($field['name'],$post_id) ) {
              $output .= '<div class="reapeater-row">';
              foreach ($fieldNames as $key => $value) {
                $subSeild = get_sub_field_object($value);
                $subSeildValue = get_sub_field($value);
                $subSeild["value"] = $subSeildValue;
                $output .= self::repeater($subSeild, $acf_version, $link_text, $post_id);
              }
              $output .= '</div>';
            }
          endif;
          $output .= '</div>';
        endif;
			} else {
        $output .= $field["type"]." is not supported";
      }
    $output .= '</div>';

    return $output;
  }

}
