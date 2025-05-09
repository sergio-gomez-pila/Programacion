package paquete;
//Clase Pelicula que representa a una película con varios atributos
public class Pelicula {
	 // Atributos de la clase
    private String id;
    private String titulo;
    private String director;
    private int ano;
    private int duracion;
    private String genero;
    // Constructor que inicializa los atributos de la película con los valores proporcionados
    public Pelicula(String id, String titulo, String director, int ano, int duracion, String genero) {
        this.id = id;
        this.titulo = titulo;
        this.director = director;
        this.ano = ano;
        this.duracion = duracion;
        this.genero = genero;
    }

    public String getId() { 
    	return id; 
    	}
    public String getTitulo() { 
    	return titulo; 
    	}
    public String getDirector() { 
    	return director; 
    	}
    public int getAno() { 
    	return ano; 
    	}
    public int getDuracion() { 
    	return duracion; 
    	}
    public String getGenero() { 
    	return genero; 
    	}
}

