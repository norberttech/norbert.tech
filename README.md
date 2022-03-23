# norbert.tech

```bash
bin/console cache:clear --env=prod
bin/console static-content-generator:generate:routes --env=prod
git commit -a -m "Latest changes commit message"
git push origin main
git subtree push --prefix=output origin gh-pages
``` 