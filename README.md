### Moodle Block Plugin: Google Search for Moodle Blocks

---

#### Description:
The Moodle Block Plugin named "Google Search for Moodle Blocks" enables users to search for "Moodle blocks" exclusively within the Moodle environment. This plugin integrates Google Custom Search functionality tailored to search specifically for Moodle-related content.

---

#### Installation and Configuration:
1. **Installation**:
   - Copy the "googlesearch_moodleblocks" folder into the "blocks" directory of your Moodle installation.
   - Ensure proper permissions for the copied files.

2. **Configuration**:
   - Access the Site Administration area of your Moodle site.
   - Navigate to Plugins > Blocks.
   - Locate the "Google Search for Moodle Blocks" block and configure the required settings:
     - Google API Key: Obtain an API key from Google Developers Console.
     - Google Custom Search ID: Obtain a Custom Search Engine ID from the Google Custom Search control panel.
     - Cache Time-to-Live (TTL): Set the time duration for cache expiration (in seconds).

---

#### Functionality:
- **Block Initialization**:
  - The block initializes with the title "Google Search for Moodle Blocks".

- **Block Content**:
  - The block retrieves search results exclusively related to Moodle blocks.
  - Search results include titles and snippets of Moodle block-related content.

- **Caching Mechanism**:
  - The plugin employs a caching mechanism to optimize performance.
  - Cached search results are utilized if available and within the configured time-to-live (TTL) period.

- **Error Handling**:
  - Appropriate error messages are displayed if API keys are not configured correctly or if no search results are found.

---

#### Usage:
- **Adding the Block**:
  - The "Google Search for Moodle Blocks" block can be added to any page where blocks are supported within Moodle, such as the dashboard or course pages.

- **Searching**:
  - Users can directly search for Moodle blocks within the Moodle environment.
  - The search functionality is integrated into the block, and users cannot input custom search queries.

---

#### Note:
- This plugin is specifically designed to search for Moodle blocks within the Moodle environment.
- Ensure proper configuration of API keys and Custom Search ID for seamless functionality.
- Utilize the cache TTL setting to balance performance and freshness of search results.

---

#### License:
This Moodle plugin is licensed under the GNU General Public License (GPL) version 3 or later. For more details, refer to the [GNU GPL v3 License](http://www.gnu.org/copyleft/gpl.html).

---

#### About the Author:
- **Author**: Alexander Schröter
- **Copyright**: 2024
