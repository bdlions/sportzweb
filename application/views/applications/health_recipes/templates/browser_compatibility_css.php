<style type='text/css'>
    /*This will work for chrome */


    @media (min-width: 992px) { 
        .table_container {
            display: table;
        }
        .cell_1st_top {
            position: relative;
            vertical-align: top;
            padding: 8px 8px 8px 8px;
            display: table-cell;
            border-right: 2px solid #E7E7E7;
            border-bottom: 2px solid #E7E7E7;
            width: 66%;
        }
        .cell_1st_bottom {
            position: relative;
            vertical-align: top;
            padding: 8px 8px 8px 8px;
            display: table-cell;
            border-right: 2px solid #E7E7E7;
            border-bottom: 2px solid #E7E7E7;
            width: 33%;;
        }
        .cell_2nd_top,.cell_2nd_middle,.cell_2nd_bottom {
            position: relative;
            vertical-align: top;
            padding: 5px;
            display: table-cell;
            border-right: 2px solid #E7E7E7;
            width: 33.33%;
        }
        .custom_mg{
            margin: 12% 0 15px 0!important;
        }
    }

    @media (max-width: 991px) { 
        .table_container {
            margin: -2%;
            padding: 2%;
        }
        .cell_1st_top {
            float: top;
            padding: 5% 0%;
        }
        .cell_1st_bottom {
            float: bottom;
            padding: 5% 0%;
        }
        .cell_2nd_top,.cell_2nd_middle,.cell_2nd_bottom {
            display: inline;
        }
    }

    /*This will work for firefox*/
    @-moz-document url-prefix() {
        @media (min-width: 992px) { 
            .table_container {
                display: table;
                margin: 0 auto;
            }
            .cell_1st_top {
                position: relative;
                left: -15px;
                vertical-align: top;
                padding: 16px 8px 8px 8px;
                display: table-cell;
                border-right: 2px solid #E7E7E7;
                border-bottom: 2px solid #E7E7E7;
                width: 66%;
            }
            .cell_1st_bottom {
                position: relative;
                left: -15px;
                vertical-align: top;
                padding: 16px 8px 8px 8px;
                display: table-cell;
                border-right: 2px solid #E7E7E7;
                border-bottom: 2px solid #E7E7E7;
                width: 33%;;
            }
            .cell_2nd_top,.cell_2nd_middle,.cell_2nd_bottom {
                position: relative;
                left: -15px;
                vertical-align: top;
                padding: 5px;
                display: table-cell;
                border-right: 2px solid #E7E7E7;
                width: 33%;
            }
        }

        @media (max-width: 991px) { 
            .table_container {
                margin: -2%;
                padding: 2%;
            }
            .cell_1st_top {
                float: top;
                padding: 5% 0%;
            }
            .cell_1st_bottom {
                float: bottom;
                padding: 5% 0%;
            }
            .cell_2nd_top,.cell_2nd_middle,.cell_2nd_bottom {
                display: inline;
            }
        }

    }
</style>

<!--[if IE]>
<style type="text/css">
  @media (min-width: 992px) { 
    .table_container {
        display: table;
        position: relative;
    }
    .cell_1st_top {
        
        left: -15px;
        vertical-align: top;
        padding: 16px 8px 8px 8px;
        display: table-cell;
        border-right: 2px solid #E7E7E7;
        border-bottom: 2px solid #E7E7E7;
        width: 66.66%;
    }
    .cell_1st_bottom {
        vertical-align: top;
        padding: 16px 8px 8px 8px;
        display: table-cell;
        border-right: 2px solid #E7E7E7;
        border-bottom: 2px solid #E7E7E7;
        width: 33.33%;
    }
    .cell_2nd_top,.cell_2nd_middle,.cell_2nd_bottom {
        vertical-align: top;
        display: inline;
        border-right: 2px solid #E7E7E7;
        width: 33.33%;
    }
}

@media (max-width: 991px) { 
    .table_container {
        margin: -2%;
        padding: 2%;
    }
    .cell_1st_top {
        float: top;
        padding: 5% 0%;
    }
    .cell_1st_bottom {
        float: bottom;
        padding: 5% 0%;
    }
    .cell_2nd_top,.cell_2nd_middle,.cell_2nd_bottom {
        display: inline;
    }
}
</style>
<![endif]-->
