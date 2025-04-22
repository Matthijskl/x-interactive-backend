Uitleg:

Ik heb geprobeerd Symfony zo goed mogelijk te vertalen naar hoe ik normaliter werk, door middel van Domain Driven Development. 
Dit bracht wel enige uitdagingen zoals alle Entities die worden aangemaakt in een Entity folder in de App namespace, en op basis daarvan migrations worden gemaakt.
Dus als ik een migration aan wilde passen moest de Entity naar de App\Entity namespace verplaatst worden.

Verder heb ik geprobeerd om ook een API token toe te voegen als beveiliging, omdat ik niet met oAuth gebruik. Om een hele authenticatie in te bouwen was ik teveel tijd kwijt helaas.
Op de een of andere manier kon mijn `services.yaml` telkens niet de `env` variabele uitlezen, en heb ik dit dus ook niet voor elkaar gekregen dus ik zou graag willen weten hoe dat moet.
Ik heb namelijk ook parameters toegevoegd in de services.yaml als dit:

```yaml
parameters:
    api_key: '%env(API_KEY)%'
```

Voorderest is de API klaar en zitten alle punten er in. 
