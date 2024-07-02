const { MongoClient } = require('mongodb');
const axios = require('axios');
const dayjs = require('dayjs');

const url = 'mongodb://localhost:27017';
const dbName = 'books';
const client = new MongoClient(url);

async function getNewBooks() {
    await client.connect();
    console.log("Connected successfully");

    const db = client.db(dbName);
    const booksCollection = db.collection('livres');

    const dateLimite = dayjs().subtract(60, 'day').toDate();

    const nouveauxLivres = await booksCollection.find({ dateAjout: { $gte: dateLimite } }).toArray();

    for (let livre of nouveauxLivres) {
        const response = await axios.get('https://www.googleapis.com/books/v1/volumes', {
            params: {
                q: `intitle:${livre.titre}`,
                key: 'AIzaSyC3qnnJF76WVoZHyslkHasazPEAUl0TzwU'
            }
        });

        const googleBooksData = response.data.items ? response.data.items[0] : null;

        if (googleBooksData) {
            const description = googleBooksData.volumeInfo.description || 'Pas de description disponible';
            const imageUrl = googleBooksData.volumeInfo.imageLinks ? googleBooksData.volumeInfo.imageLinks.thumbnail : 'Assets/Image/no-books.png';

            await booksCollection.updateOne(
                { _id: livre._id },
                { $set: { description, imageUrl } }
            );

            console.log(`Updated: ${livre.titre}`);
        } else {
            console.log(`Aucune information trouvée pour: ${livre.titre}`);
        }
    }

    await client.close();
    console.log("Disconnected successfully");
}

getNewBooks().catch(console.error);
