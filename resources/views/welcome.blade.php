@extends('layouts.app')

@section('content')
<div id="templatemo_container">
    <div id="templatemo_menu">
        <ul>
            <li><a href="index.html" class="current">Home</a></li>
            <li><a href="subpage.html">Search</a></li>
            <li><a href="subpage.html">Books</a></li>            
            <li><a href="subpage.html">New Releases</a></li> 
            <li><a href="#">Contact</a></li>             
            <li><a href="#">Login</a></li>
        </ul>
    </div>
    <div id="templatemo_header">
        <div id="templatemo_special_offers">
            <p>
                <span>25%</span> discounts for
                purchase over $80
            </p>
        </div>      
        <div id="templatemo_new_books">
            <ul>
                <li>Suspen disse</li>
                <li>Maece nas metus</li>
                <li>In sed risus ac feli</li>
            </ul>
            <a href="subpage.html" style="margin-left: 50px;">Read more...</a>
        </div>
    </div>
    <div id="templatemo_content">

        <div id="templatemo_content_left">
            <div class="templatemo_content_left_section" id="categories">
                <h1>Categories</h1>
                <ul>
                    <li v-for="category in categories">
                        <a :href="'{{URL::to('/')}}/category/'+category.name.split(' ').join('-')">
                        @{{category.name}}
                        </a>
                    </li>
                    <li v-if="categories.length == 5"><a href="#">See More...</a></li>
                </ul>
            </div>
            <div class="templatemo_content_left_section">
                <h1>Bestsellers</h1>
                <ul>
                    <li><a href="#">Vestibulum ullamcorper</a></li>
                    <li><a href="#">Maece nas metus</a></li>
                    <li><a href="#">In sed risus ac feli</a></li>
                    <li><a href="#">Praesent mattis varius</a></li>
                    <li><a href="#">Maece nas metus</a></li>
                    <li><a href="#">In sed risus ac feli</a></li>
                    <li><a href="#">Flash Templates</a></li>
                    <li><a href="#">CSS Templates</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="http://www.photovaco.com" target="_parent">Free Photos</a></li>
                </ul>
            </div>
            <div class="templatemo_content_left_section">                
              <p>
                  You can add new card samll.
              </p>
            </div>
        </div>
        <div id="templatemo_content_right">
            <div class="templatemo_product_box">
                <h1>Photography  <span>(by Best Author)</span></h1>
                <img src="{{ asset('storage/images/templatemo_image_01.jpg') }}" alt="image" />
                <div class="product_info">
                    <p>Etiam luctus. Quisque facilisis suscipit elit. Curabitur...</p>
                    <h3>$55</h3>
                    <div class="buy_now_button"><a href="subpage.html">Buy Now</a></div>
                    <div class="detail_button"><a href="subpage.html">Detail</a></div>
                </div>
                <div class="cleaner">&nbsp;</div>
            </div>

            <div class="cleaner_with_width">&nbsp;</div>

            <div class="templatemo_product_box">
                <h1>Cooking  <span>(by New Author)</span></h1>
                <img src="{{ asset('storage/images/templatemo_image_02.jpg') }}" alt="image" />
                <div class="product_info">
                    <p>Aliquam a dui, ac magna quis est eleifend dictum.</p>
                    <h3>$35</h3>
                    <div class="buy_now_button"><a href="subpage.html">Buy Now</a></div>
                    <div class="detail_button"><a href="subpage.html">Detail</a></div>
                </div>
                <div class="cleaner">&nbsp;</div>
            </div>

            <div class="cleaner_with_height">&nbsp;</div>

            <div class="templatemo_product_box">
                <h1>Gardening <span>(by Famous Author)</span></h1>
                <img src="{{ asset('storage/images/templatemo_image_03.jpg') }}" alt="image" />
                <div class="product_info">
                    <p>Ut fringilla enim sed turpis. Sed justo dolor, convallis at.</p>
                    <h3>$65</h3>
                    <div class="buy_now_button"><a href="subpage.html">Buy Now</a></div>
                    <div class="detail_button"><a href="subpage.html">Detail</a></div>
                </div>
                <div class="cleaner">&nbsp;</div>
            </div>

            <div class="cleaner_with_width">&nbsp;</div>

            <div class="templatemo_product_box">
                <h1>Sushi Book  <span>(by Japanese Name)</span></h1>
                <img src="{{ asset('storage/images/templatemo_image_04.jpg') }}" alt="image" />
                <div class="product_info">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                    <h3>$45</h3>
                    <div class="buy_now_button"><a href="subpage.html">Buy Now</a></div>
                    <div class="detail_button"><a href="subpage.html">Detail</a></div>
                </div>
                <div class="cleaner">&nbsp;</div>
            </div>
            <div class="cleaner_with_height">&nbsp;</div>
            <a href="subpage.html"><img src="{{ asset('storage/images/templatemo_ads.jpg') }}" alt="ads" /></a>
        </div>
        <div class="cleaner_with_height">&nbsp;</div>
    </div>
    <div id="templatemo_footer">
        <a href="subpage.html">Home</a> | <a href="subpage.html">Search</a> | <a href="subpage.html">Books</a> | <a href="#">New Releases</a> | <a href="#">FAQs</a> | <a href="#">Contact Us</a><br />
        Copyright © 2018 <a href="#"><strong>Innovative Idea</strong></a> 
    </div>
</div>
@endsection
@section('scripts')
    <script>
        const app = new Vue({
            el:'#categories',
            data:{
                categories : {}
            },
            methods: {
                getGenres(){
                    axios.get(app_url+`/api/genre/all`)
                        .then((response) =>{
                            this.categories = response.data;
                            console.log(this.categories.length);
                            if(this.categories.length >5)
                            {
                                this.categories.splice(5, this.categories.length);
                            }
                            console.log(this.categories.length);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                listen(){
                    
                    Echo.channel('genre.refresh')
                    .listen('RefershGenre',()=>{
                        this.getGenres();
                    });
                }
            },
            mounted (){
                this.getGenres();
                this.listen();
            }
        })
    </script>
@endsection
