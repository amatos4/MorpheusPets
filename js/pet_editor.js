(function ( $ )
{

  // Inputs
  var species_input = $( "#pet_species" );

  // Containers
  var species_details_container = $( "#pet_species_details" );

  var update_species_details = function ( species_id )
  {
    var species_id_num = parseInt( species_id );

    var species_details_message_element = $( "<p></p>" );

    if ( species_id_num === 0 )
    {
      species_details_message_element.text( "Please select a species to see more details" );

      species_details_container.html( "" );
      species_details_container.append( species_details_message_element );
    }
    else if ( !isNaN( species_id_num ) )
    {
      // Species detail elements
      var name_element                 = $( "<h3>" ),
          image_element                = $( "<img>" ),
          type_element                 = $( "<p>" ),
          stat_priority_container      = $( "<article class='pet-stat-priority'>" ),
          stat_priority_header_element = $( "<h3>" ),
          stat_priority_list_element   = $( "<ol>" );

      var species_details_submission_data = {
        json: true,
        species_id: species_id_num
      };

      var species_details_promise = $.get( "species.php", species_details_submission_data );

      species_details_promise.then( function ( species_details )
      {
        // Clear existing text
        species_details_container.html ( "" );

        if ( species_details )
        {
          name_element.text( species_details.species );
          species_details_container.append( name_element );

          image_element.attr( "src", species_details.image_url );
          image_element.attr( "alt", species_details.species );
          species_details_container.append( image_element );

          type_element.html( "<b>Type: </b> " + species_details.type );
          species_details_container.append( type_element );

          // Stat priority
          stat_priority_header_element.text( "Stat Priority" );
          stat_priority_container.append( stat_priority_header_element );

          species_details.stat_priority.forEach( function ( stat )
          {
            var species_stat_priorities_list_item_element = $( "<li>" );

            species_stat_priorities_list_item_element.html( "<b>" + stat + "</b>" );
            stat_priority_list_element.append( species_stat_priorities_list_item_element );
          } );
          stat_priority_container.append( stat_priority_list_element );

          species_details_container.append( stat_priority_container );
        }
        else
        {
          species_details_message_element.text( "There are no details for the selected species. Please select another species." );
          species_details_container.append( species_details_message_element );
        }
      }, function ( reason )
      {
        // Clear existing text
        species_details_container.html ( "" );

        species_details_message_element.text( "Failed to get species details. Please try selecting another species." );
        species_details_container.append( species_details_message_element );
      } )
    }
  };

  // Add event listener to species selector
  species_input.on( "change", function ( event )
  {
    update_species_details( species_input.val() );
  } );

  // Initial update of species details
  update_species_details( species_input.val() );
})( $ );
