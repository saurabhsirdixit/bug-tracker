 $(document).ready(function() {

        posts = 8;
        author_posts = parseInt(<?php echo $author_posts; ?>);

        $("#link_selector").click(function() {

            // alert('posts - ' + posts + 'author posts - ' + author_posts);


            if ((posts - author_posts) > 3) {
                $("#link_selector").text('No more posts!');
            }
            else {

                var category        = '<?php echo strtolower($category); ?>';
                var id              = '<?php echo $blogger_id; ?>';
                var firstname       = '<?php echo $firstname; ?>';
                var surname         = '<?php echo $surname; ?>';


                // alert(posts + category + id + firstname + surname);

                $.ajax({
                    type: "GET",
                    url: "/wordpress/wp-admin/admin-ajax.php",
                    dataType: 'html',
                    data: ({ action: 'loadMore', id: id, post_name: post_name, post_title: ppost_titile}),
                    success: function(data){
                        $('#ajax_results_container').hide().fadeIn('slow').html(data);
                        posts = posts + 4;

                        if ((posts - author_posts) > 3) {
                            $("#link_selector").text('No more posts!');
                        }

                    }
                });
            }

        });
    });
