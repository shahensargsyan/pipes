<template>
<div id="carousel" class="reviews_div slider">
    <div class="block__content">
        <div v-if="isLoading">
            <div class="half-circle-spinner">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
        </div>
        <div class="slider-item reviews_item" v-if="!isLoading && data.length" v-for="item in data" :key="item.id">

                <div class="rev_product_img">
                    <img :src="item.user_avatar!=''?'storage/'+item.user_avatar:'storage/reviews/default-user-image.png'"  :alt="item.user_name" width="60" />
                </div>
                <div class="rev_product_info">

                    <div class="star_rating_div">
                        <div class="star-rating" role="img" aria-label="Rated 4.66 out of 5"><span
                            :style="{width: item.star * 20 + '%'}">Rated <strong
                            class="rating">{{ item.star }}</strong> out of 5</span></div>
                        <div class="rev_date">
                            {{ item.created_at }}
                        </div>
                    </div>
                    <div class="rev_product_description">
                        <p>{{ item.comment }}</p>
                    </div>
                    <div class="rev_title_btn">
                        <h3>{{ item.user_name }}</h3>
                        <button class="verified_btn">Verified Buyer</button>
                    </div>
                </div>


        </div>

    </div>
</div>
</template>

<script>
    export default {
        data: function() {
            return {
                isLoading: true,
                data: [],
                meta: {},
                userProfilePic: null
            };
        },
        props: {
            url: {
                type: String,
                default: () => null,
                required: true
            },
        },
        mounted() {
          this.getData();
        },
        methods: {
            getData(page = 1) {
                this.data = [];
                this.isLoading = true;
                axios.get(this.url + '?page=' + page)
                    .then(res => {
                        console.log(res.data.data)
                        this.data = res.data.data;
                        this.meta = res.data.meta;
                        this.isLoading = false;
                        setTimeout(function(){
                            slider();
                            $("#banner").attr('src',$("#banner").attr('tsrc')) .removeAttr('tsrc');
                        }, 500);
                    })
                    .catch(res => {
                        this.isLoading = false;
                        console.log(res);
                    });
            }
        }
    }
</script>
