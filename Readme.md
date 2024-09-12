
# Symfony Case

Bu proje iş görüşmesi sonucunda bana iletilen bir case çalışmasıdır.

projenin çalışır haline bu linkten ulaşabilirsiniz : https://case.brylmaz.com.tr/ 

.env dosyasında provider ekleyebilirsiniz ancak yazıldığı gibi sıralı bir şekilde ekleme yapabilirsiniz.

örneğin: 

PROVIDER1_URL="https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-one"
PROVIDER2_URL="https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-two"


## Kurulum

Öncelikle projeyi kendi localinize clone edin

```bash
  git clone https://github.com/brylmaz/symfonyCase.git
```

daha sonra sırasıyla bu komutları çalıştırın. 

```bash
  cd symfonyCase
  cd .docker

  docker compose up --build -d
```
projemiz ayağa kalktıktan sonra php containerın içine girip yine sırasıyla aşağıdaki komutları çalıştırın.

```bash
  docker exec -it <container_id> bash

  composer install

  php bin/console doctrine:schema:update --force // veritabanı tablolarının oluşması için

  php bin/console doctrine:fixtures:load   // Bu komut varsayılan olarak tüm fixture dosyalarını yükler ve mevcut verileri siler.

  php bin/console providers:getDataSaveDatabase // tabloları mock verilerle doldurmak için (bir kez çalıştırmanız yeterlidir)

```

Tüm bu adımlar başarılı şekilde yaptıysanız "localhost:3452" web tarayıcısına yazarak erişebilirsiniz.



