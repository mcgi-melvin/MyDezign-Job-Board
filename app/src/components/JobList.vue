<template>
    <main class="job-list">
        <div class="container-placeholder" v-if="!jobs.length"></div>
        <div class="container-placeholder" v-if="!jobs.length"></div>
        <div class="container-placeholder" v-if="!jobs.length"></div>
        <transition-group name="job-transition">
        <div v-for="job in jobs" :key="job.job_id" :class="[ job.job_id ? 'item-' + job.job_id : '' ]" class="job-item">
            <div class="job-info">
                <div class="info-basic">
                    <h3>{{job.title}}</h3>
                    <div class="short-description">
                        <p>{{ job.excerpt }}</p>
                    </div>
                </div>
                <div class="info-other">
                    <p>{{ job.date_posted }}</p>
                    <p>{{ job.salary }}</p>
                    <p>{{ job.job_type.name }}</p>
                    <p>{{ job.company_name }}</p>
                    <p>{{ job.job_location || 'Anywhere' }}</p>
                </div>
            </div>
            <div class="job-buttons">
                <router-link :to="`job/${ job.job_id} `">View Job</router-link>
            </div>
        </div>
        </transition-group>

        <div class="job-pagination" v-if="total_pages > 0">
            <ul class="pagination">
                <li v-for="page in total_pages" :key="page">
                    <a
                    :class="[
                        page ? `page-${page}` : '',
                        page == paged ? 'active': '',
                        { 'show': current_pagination( page ) }
                    ]"
                    class="pagi-item"
                    href="javascript:void(0)"
                    @click="set_page( page )">
                    {{ page }}
                    </a>
                </li>
            </ul>
        </div>

    </main>    
</template>
<script>
export default {
    name: '',
    data() {
        return {
            total_pages: 0,
            pagi_start_count: 1,
            pagi_end_count: 4,
            form: {
                title: '',
            },
            loader: true
        }
    },
    methods: {
        current_pagination: function( page ) {
            return page >= this.pagi_start_count && page <= this.pagi_end_count;
        },
        set_page( page ) {
            this.pagi_start_count = page - 2
            this.pagi_end_count = page + 2
            this.$job_options.paged = page
            //this.paged = page;
        },
    },
    created() {
        //this.fetchJobs()
        this.get_jobs( true )
    },
    watch: {
        '$job_options.jobs' () {
            console.log( 'Job List Updated !' )
            this.jobs = this.$job_options.jobs
            this.get_jobs()
        },
        '$job_options.paged' () {
            console.log( 'Paged Changed : ' + this.$job_options.paged )
            this.paged = this.$job_options.paged
            this.get_jobs( true )
        },
        '$job_options.keyword' () {
            console.log( 'Keyword Changed : ' + this.$job_options.keyword )
            this.keyword = this.$job_options.keyword
            this.get_jobs( true )
        },
        '$job_options.location' () {
            console.log( 'Location Changed : ' + this.$job_options.location )
            this.keyword = this.$job_options.location
            this.get_jobs( true )
        },
        '$job_options.job_type' () {
            console.log( 'Job Type Changed : ' + this.$job_options.job_type )
            this.keyword = this.$job_options.job_type
            this.get_jobs( true )
        },
        '$job_options.job_category' () {
            console.log( 'Job Category Changed : ' + this.$job_options.job_category )
            this.keyword = this.$job_options.job_category
            this.get_jobs( true )
        }
    }
}
</script>
<style scoped>
.job-item {
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    border-bottom: 5px solid #DD8041;
    margin: 0 0 15px;
}
.job-item .job-info {
    display: flex;
    flex-wrap: wrap;
}
.job-item .info-basic {
    width: calc(100% - 150px);
    padding: 15px 20px;
}
.job-item .info-basic h3 {
    color: #183c40;
    font-size: 16px;
}
.job-item .info-basic p {
    font-size: 12px;
    font-weight: 300;
    word-break: break-word;
}
.job-item .info-other {
    background: #F3F3F3;
    width: 150px;
    padding: 20px 15px; 
}
.job-item .info-other p {
    color: #DD8041;
    font-size: 8px;
    font-weight: bold;
    margin-top: 0;
}
.job-item .job-buttons a {
    height: 40px;
    background: #183c40;
    color: #fff;
    font-size: 10px;
    font-weight: 300;
    text-decoration: none;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
}
.job-pagination {
    position: fixed;
    width: 100%; 
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    text-align: center;
}
.pagination {
    padding: 0;
    margin: 0;
    display: inline-block;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
}
.pagination li {
    display: inline-block;
}
.pagination li a {
    display: none;
    text-decoration: none;
    color: #183c40;
    padding: 20px;
    background: #fff;
}
.pagination li a.show {
    display: block;
}
.pagination li a.active {
    color: #fff;
    background: #DD8041;
}

.job-transition-item {
    display: inline-block;
    margin-right: 10px;
}
.job-transition-enter-active {
    transition: all 0.4s ease-out;
    opacity: 0;
}
.job-transition-leave-active {
  
}
.job-transition-enter {

}
.job-transition-leave-to /* .list-leave-active below version 2.1.8 */ {
    opacity: 1;
}

@media (max-width: 480px) {
    .job-item .info-basic,
    .job-item .info-other {
        width: 100%
    }
    .job-item .info-other {
        column-count: 2;
    }
}
</style>