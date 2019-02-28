# Sitzplan API

## API Verwendung / erlaubte Endpunkte

### Import Raumbelegung aus CSV Datei
```
curl http://localhost/api/import/ -i -F "file=@/users/aprudnikov/SERVER/sitzplan.csv"
```

### Raumbelegung abfragen (ohne Raumnummer -> alle Räume ausgegeben)
```
curl http://localhost/api/room/
curl http://localhost/api/room/1234
```

### API Antwort:
immer als Json, für Import - mit HTTP Header Infos
JSON_UNESCAPED_UNICODE und JSON_PRETTY_PRINT sind aktivert.

### Pattern für Import Parsing Benutzerdaten
Pattern: *ggf. Titel Vorname ggf. Zweitname(n) ggf. Namenszusatz Nachname (LDAP-Username)*
```
'/^(?<title>Dr\.)?\s*(?<firstName>(\b(?!(van|von|de)\b)\S+\s*)+)\s+(?<nameAddition>van|von|de)?\s*(?<lastName>\S+)\s+\((?<ldapUser>\S+)\)$/i';
```

## Author

* **Alexey Prudnikov** - *aprudnikov* - [a.prudnikov@neusta.de](mailto:a.prudnikov@neusta.de)
