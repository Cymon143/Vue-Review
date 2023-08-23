import Vue from 'vue';
import Moment from 'moment';
import { data } from 'jquery';

Vue.filter('readableTime', function(date){
    if(date && date != ''){
        return Moment('2000-01-01 '+date).format('h:mm A');
    }
    return '';
});
Vue.filter('ordinal', function(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
})
Vue.filter('capitalizeWords', function(value){
    if(value !='' && value){
        return value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
    }
    return value;
});
Vue.filter('readableDate', function(date){
    return Moment(date).format('MMM D, yyyy');
});
Vue.filter('schoolYear', function(year){
    return year+'-'+parseInt(year)+1;
});
Vue.filter('truncate', function(text, stop, clamp){
    if(text){
        return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
    }
});
Vue.filter('padZero', function(id_number, length = 4){
    if(!id_number || id_number == ''){
        return id_number;
    }
    else{
        var str = '' + id_number;
        while (str.length < length) {
            str = '0' + str;
        }
        return str;
    }
});
