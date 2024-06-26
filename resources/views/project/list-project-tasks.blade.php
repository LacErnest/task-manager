
<x-list-tasks :project="$project" />

<script>
  $( function() {
    
        var idsBeforeSort = [];
    
        $( "#tasks-drop" ).sortable({
          connectWith: ".connectedSortable",
          opacity: 0.5,
        });

        $( ".connectedSortable" ).on( "sortstart", function( event, ui ) {
            $("#tasks-drop li").each(function( index ) {
                if($(this).attr('item-id')){
                  idsBeforeSort[index] = $(this).attr('item-id');  
                }
            });
          });

        $( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
            var idsAfterSort = [];
            $("#tasks-drop li").each(function( index ) {
              if($(this).attr('item-id')){
                idsAfterSort[index] = $(this).attr('item-id');  
              }
            });

            if(idsAfterSort[0] != idsBeforeSort[0]){
                  
                $.ajaxSetup({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });
          
                $.ajax({
                  url: "{{ url('/project/'.$project->id.'/reorderTasks') }}",
                  method: 'POST',
                  data: {ids: idsAfterSort},
                      success: function(data) {
                        $('#project-info-div').load("{{ url('project/show/' . $project->id) }}");
                      }
                });
          }
        });

    })
</script>