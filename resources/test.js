// test.js

// Import the `mount()` method from the test utils
// and the component you want to test
import { mount } from '@vue/test-utils';
import { createLocalVue } from '@vue/test-utils';
import BootstrapVue from 'bootstrap-vue';
import App from '@/js/views/App.vue';

const localVue = createLocalVue();
localVue.use(BootstrapVue);

describe('App', () => {
    // Now mount the component and you have the wrapper
    const wrapper = mount(App, { localVue });
    console.log(wrapper);
  
    it('renders the correct markup', () => {
      expect(wrapper.html()).toContain('<span class="count">0</span>')
    });
  
    // it's also easy to check for the existence of elements
    it('has a button', () => {
      expect(wrapper.contains('button')).toBe(true)
    });
});