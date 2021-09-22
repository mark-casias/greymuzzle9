# Greymuzzle.org

## Composer-enabled Drupal template

This is Pantheon's recommended starting point for forking new Drupal upstreams
that work with the Platform's Integrated Composer build process. It is also the
Platform's standard Drupal 9 upstream.

Unlike with earlier Pantheon upstreams, files such as Drupal Core that you are
unlikely to adjust while building sites are not in the main branch of the
repository. Instead, they are referenced as dependencies that are installed by
Composer.

For more information and detailed installation guides, please visit the
Integrated Composer Pantheon [documentation](https://pantheon.io/docs/integrated-composer)

## Reference Sites

- [Current Site](https://www.greymuzzle.org)
- [D9 Build on Pantheon](https://dev-greymuzzle9.pantheonsite.io/)
- [TailwindCSS](https://www.tailwindcss.com)

## Theme

This is a reproduction of the current theme available at [our current site](https://www.greymuzzle.org). It is in progress. Currently the theme is extending the Olivero theme, but I am quickly finding this does not work. I am looking to use:

- TailwindCSS
- Patternlab

Of course, I may not get what I want. Feel free to fork and merge request any suggestions.

### Theme Build

Right now I am using patternlab to create components and TailwindCSS as the base components. This does not relate to anything you see if you review the current build of the D9 site. BUT that being said, here are the steps to build patternlab and the tailwindcss.

- `nvm install`: Installs the locked version of node (v15.7.0 at this commit)
- `npm install`: Installs all the things
- `npm run build`: Builds out CSS from `source/css/styles.css` to `public/css/patterns.css`.
- `npm run serve`: Creates PL instance on your machine at port 3000 for your pattern review.

### @todo for theme

- Link Drupal Template files to Patterns (fields, views, paragraphs, node/full, node/teaser, page)
- Apply CSS to theme
- Convert CSS to tailwind instead of whatever we did for the D7 conversion.

#### Caveats

There are two commands you have to do. The CSS build and PatternLab are decoupled at this point. See the package.json for details on NPM commands.

I am working on a solution where you can build both, but right now, that doesn't happen.

## @todo for project

Feel free to create an issue in [GITHUB](https://github.com/mark-casias/greymuzzle9) and fork.

- Finish Patternlab conversion
- Homepage to Page content type with Paragraphs
- Apply patterns to template files in Drupal
- Refresh DB with lates import
- [Donate to greymuzzle.org](https://greymuzzle.z2systems.com/np/clients/greymuzzle/donation.jsp?campaign=51&)
- Create CI to attach this repo to Pantheon
