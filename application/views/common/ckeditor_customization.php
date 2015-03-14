<script>
    /*
     * this functions takes a source string and remove html tags
     * excluding tags after '<(?!\/? in var regex.
     * 
     * <(?!\/?(p)|(a)(?...  removes tags excluding para and anchor.
     */
    function filter_html_tags(source_tags){
        var regex = '<(?!\/?(p|a)\s*.*(?=>|\s.*>))\/?.*?>';
//        var regex = '<(?!\/?(p)|(a)(?=>|\s.*>))\/?.*?>';
        regex = new RegExp(regex, 'gi');
        source_tags = source_tags.replace( regex, '' );
        return source_tags;
    }

</script>