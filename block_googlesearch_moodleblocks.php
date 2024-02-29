<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version metadata for the repository_pluginname plugin.
 *
 * @package   block_googlesearch_moodleblocks
 * @copyright 2024, Alexander Schröter
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_googlesearch_moodleblocks extends block_base
{

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_googlesearch_moodleblocks');
    }

    /**
     * Indicates whether the block has settings.
     *
     * @return bool
     */
    public function has_config()
    {
        return true;
    }

    /**
     * Gets the block contents.
     *
     * @return string The block HTML.
     */
    public function get_content()
    {

        if ($this->content !== null) {
            return $this->content;
        }

        $content = '';
        $cache_time = 0;
        // Get Google API key and custom search ID
        $google_api_key = get_config(plugin: 'block_googlesearch_moodleblocks', name: 'google_api_key');
        $google_custom_search_id = get_config(plugin: 'block_googlesearch_moodleblocks', name: 'google_custom_search_id');

        $cache = cache::make('block_googlesearch_moodleblocks', 'googlesearch_moodleblocks_data');

        // Check if Google API key and Custom Search ID are set
        if ($google_api_key && $google_custom_search_id) {

            // Check if the data is cached and retrieve it if available
            if ($this->check_cache($cache)) {
                $cached = $cache->get('api_response');
                $response = $cached['content'];
                $cache_time = $cached['time'];
            } else {
                // If data is not cached, make a request to Google Custom Search API
                $query = urlencode('Moodle Blocks');
                // Create URL for Google search with obtained parameters
                $url = "https://www.googleapis.com/customsearch/v1?q=$query&key=$google_api_key&cx=$google_custom_search_id";
                // Fetch response from Google search
                $response = file_get_contents($url);

                // Cache the API response
                $cache->set('api_response', ['time' => time(), 'content' => $response]);
                $cache_time = time();
            }

            $cached = $cache->get('api_response');
            // Decode response in JSON format
            $data = json_decode($response, true);

            // Process the response data
            if (isset($data['items'])) {
                // If search results exist, display them
                foreach ($data['items'] as $item) {
                    $content .= '<div class="item"><a href="' . $item['link'] . '">' . $item['title'] . '</a><br>' . $item['snippet'] . '</div>';
                }
            } else {
                // Display a message if no results are found
                $content = '<div class="item -warning">' . get_string(identifier: 'noresults', component: 'block_googlesearch_moodleblocks') . '</div>';
            }
        } else {
            // Display an error message if API keys are not set
            $content = '<div class="item -error">' . get_string(identifier: 'nokeys', component: 'block_googlesearch_moodleblocks') . '</div>';
        }

        // Set the block content and footer
        $this->content = new stdClass();
        $this->content->text = $content;
        $this->content->footer = '<div class="footer">' . get_string(identifier: 'footertext', component: 'block_googlesearch_moodleblocks') . date("d.m.Y H:i:s", $cache_time) . '</div>';

        return $this->content;
    }

    /**
     * Checks for the existence of the cache item and if the time-to-live (TTL) has expired.
     *
     * @return bool
     */
    public function check_cache($cache)
    {
        $cache_ttl = get_config(plugin: 'block_googlesearch_moodleblocks', name: 'cache_ttl');
        if ($cached = $cache->get('api_response')) {
            if ((time() - $cached['time']) > $cache_ttl) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats()
    {
        return [
            'admin' => false,
            'site-index' => true,
            'course-view' => false,
            'mod' => false,
            'my' => true,
        ];
    }
}
