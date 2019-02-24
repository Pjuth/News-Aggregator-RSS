<template>
    <div class="container">
        <div class="row">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                        <a class="page-link" @click="fetchFeeds(pagination.prev_page_url)">Previous</a>
                    </li>

                    <li class="page-item disabled">
                        <a class="page-link text-dark">Page {{ pagination.current_page }} of
                            {{pagination.last_page }}</a>
                    </li>

                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                        <a class="page-link" @click="fetchFeeds(pagination.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2" v-for="feed in feeds">
                    <h3>{{ feed.title }}</h3>
                    <p>{{ feed.description }}</p>
                    <p><a :href="feed.link">Skaitykite daugiau...</a></p>
                    <p> {{ feed.pubDate }}</p>
                    <p> {{ feed.thumbnail }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Feeds",
        data() {
            return {
                feeds: [],
                feed: {
                    title: '',
                    link: '',
                },
                pagination: {},
            }
        },
        created() {
            this.fetchFeeds();
        },
        methods: {
            fetchFeeds(page_url) {
                page_url = page_url || '/api/feeds';
                fetch(page_url).then(res => res.json()).then(res => {
                    this.feeds = res;
                    // this.makePagination(res.meta, res.links);
                }).catch(err => console.log(err));
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },
            readXml(xml) {
                let serializer = new XMLSerializer();
                console.log(serializer.serializeToString(xml));
            },
        }
    }
</script>

<style scoped>

</style>