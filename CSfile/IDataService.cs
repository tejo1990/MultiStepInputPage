public interface IDataService
{
    Task<bool> SaveBoothDataAsync(BoothData boothData);
}