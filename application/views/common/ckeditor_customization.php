<script>
    /*
     * this functions takes a source string and remove html tags
     * excluding tags after '<(?!\/? in var regex.
     * 
     * <(?!\/?(p)|(a)(?...  removes tags excluding para and anchor.
     */
    function filter_html_tags(source_tags){
        var regex = '<(?!\/?(p|a)\s*.*(?=>|\s.*>))\/?.*?>';
        regex = new RegExp(regex, 'gi');
        source_tags = source_tags.replace( regex, '' );
        
        regex = '<p\s*[^>]*>';
        regex = new RegExp(regex, 'gi');
        source_tags = source_tags.replace( regex, '<p>' );
        
        regex = '<\/p\s*[^>]*>';
        regex = new RegExp(regex, 'gi');
        source_tags = source_tags.replace( regex, '</p>' );
        
        regex = '<a\s*[^>]*>';
        regex = new RegExp(regex, 'gi');
        source_tags = source_tags.replace( regex, '<a>' );
        
        regex = '<\/a\s*[^>]*>';
        regex = new RegExp(regex, 'gi');
        source_tags = source_tags.replace( regex, '</a>' );
        
        return source_tags;
    }

</script>