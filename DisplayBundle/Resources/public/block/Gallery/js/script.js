requirejs(
    ['../../../fancybox/source/jquery.fancybox.pack',
     '../../../fancybox/source/helpers/jquery.fancybox-buttons',
     '../../../fancybox/source/helpers/jquery.fancybox-media',
     '../../../fancybox/source/helpers/jquery.fancybox-thumbs'
    ],
    function () {

        function resizeThumbnails(galId, nbCol) {
            if (galId == '') alert('Error : no id defined for gallery');
            var picturePadding = parseInt($(".gallery-picture").css("border-left-width")) + parseInt($(".gallery-picture").css("margin-left"));
            var galleryWidth = parseInt($("#" + galId).width());
            var pictureWidth = parseInt((galleryWidth / nbCol) - 2*picturePadding);

            $("#" + galId + " .gallery-picture").width(pictureWidth + 'px');
            $("#" + galId + " .gallery-picture").css("visibility", "visible");
        }

        $(document).ready(function() {
            for(var galleryId in orchestraGalCol) {
                resizeThumbnails(galleryId, orchestraGalCol[galleryId]);
            }

            $(".fancybox-thumb").fancybox({
                prevEffect  : 'none',
                nextEffect  : 'none',
                closeBtn    : false,
                helpers     : {
                    title     : {
                        type    : 'inside'
                    },
                    thumbs    : {
                        width   : 50,
                        height  : 50
                    }
                }
            });
        });

    }
);
